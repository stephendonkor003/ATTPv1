<?php

namespace App\Http\Controllers;

use App\Models\Funder;
use App\Models\User;
use App\Models\Role;
use App\Models\PartnerActivityLog;
use App\Mail\FundingPartnerWelcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FunderController extends Controller
{
    /**
     * Display a listing of funders.
     */
    public function index()
    {
        $funders = Funder::orderBy('name')->get();

        return view('finance.funders.index', compact('funders'));
    }

    /**
     * Show the form for creating a new funder.
     */
    public function create()
    {
        return view('finance.funders.create');
    }

    /**
     * Store a newly created funder.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255|unique:myb_funders,name',
            'type'               => 'required|in:government,donor,internal,private',
            'currency'           => 'required|string|max:10',
            'logo'               => 'nullable|image|mimes:jpeg,jpg,png,svg|max:2048',
            'has_portal_access'  => 'nullable|boolean',
            'contact_person'     => 'required_if:has_portal_access,1|string|max:255',
            'contact_email'      => 'required_if:has_portal_access,1|email|max:255|unique:users,email',
            'contact_phone'      => 'nullable|string|max:20',
            'notes'              => 'nullable|string',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('funders/logos', 'public');
        }

        $funder = Funder::create($validated);

        // Handle portal access
        if ($request->boolean('has_portal_access')) {
            $password = Str::random(12);

            // Create user account for partner
            $user = User::create([
                'name'                  => $validated['contact_person'],
                'email'                 => $validated['contact_email'],
                'password'              => Hash::make($password),
                'user_type'             => 'funding_partner',
                'role_id'               => Role::where('name', 'Funding Partner')->first()->id,
                'must_change_password'  => true,
            ]);

            // Link user to funder
            $funder->update(['user_id' => $user->id]);

            // Send welcome email with credentials
            try {
                Mail::to($user->email)->send(new FundingPartnerWelcome($funder, $user, $password));
            } catch (\Exception $e) {
                // Log error but don't fail the request
                \Log::error('Failed to send partner welcome email: ' . $e->getMessage());
            }

            // Log activity
            PartnerActivityLog::logActivity(
                funderId: $funder->id,
                userId: $user->id,
                action: 'account_created',
                metadata: ['created_by' => auth()->id()]
            );
        }

        return redirect()
            ->route('finance.funders.index')
            ->with('success', 'Funder created successfully.' . ($request->boolean('has_portal_access') ? ' Portal access email sent.' : ''));
    }

    /**
     * Show the form for editing the specified funder.
     */
    public function edit(Funder $funder)
    {
        return view('finance.funders.edit', compact('funder'));
    }

    /**
     * Update the specified funder.
     */
    public function update(Request $request, Funder $funder)
    {
        $emailRule = 'required_if:has_portal_access,1|email|max:255|unique:users,email';

        // If funder already has a user, allow the same email
        if ($funder->user_id) {
            $emailRule .= ',' . $funder->user_id;
        }

        $validated = $request->validate([
            'name'               => 'required|string|max:255|unique:myb_funders,name,' . $funder->id,
            'type'               => 'required|in:government,donor,internal,private',
            'currency'           => 'required|string|max:10',
            'logo'               => 'nullable|image|mimes:jpeg,jpg,png,svg|max:2048',
            'has_portal_access'  => 'nullable|boolean',
            'contact_person'     => 'required_if:has_portal_access,1|string|max:255',
            'contact_email'      => $emailRule,
            'contact_phone'      => 'nullable|string|max:20',
            'notes'              => 'nullable|string',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($funder->logo) {
                \Storage::disk('public')->delete($funder->logo);
            }
            $validated['logo'] = $request->file('logo')->store('funders/logos', 'public');
        }

        // Handle portal access changes
        if ($request->boolean('has_portal_access') && !$funder->user_id) {
            // Portal access enabled for the first time
            $password = Str::random(12);

            $user = User::create([
                'name'                  => $validated['contact_person'],
                'email'                 => $validated['contact_email'],
                'password'              => Hash::make($password),
                'user_type'             => 'funding_partner',
                'role_id'               => Role::where('name', 'Funding Partner')->first()->id,
                'must_change_password'  => true,
            ]);

            $validated['user_id'] = $user->id;

            // Send welcome email
            try {
                Mail::to($user->email)->send(new FundingPartnerWelcome($funder, $user, $password));
            } catch (\Exception $e) {
                \Log::error('Failed to send partner welcome email: ' . $e->getMessage());
            }

            // Log activity
            PartnerActivityLog::logActivity(
                funderId: $funder->id,
                userId: $user->id,
                action: 'account_created',
                metadata: ['updated_by' => auth()->id()]
            );
        } elseif (!$request->boolean('has_portal_access') && $funder->user_id) {
            // Portal access disabled - remove user link (but don't delete user)
            $validated['user_id'] = null;
            $validated['has_portal_access'] = false;
        }

        $funder->update($validated);

        return redirect()
            ->route('finance.funders.index')
            ->with('success', 'Funder updated successfully.');
    }
}