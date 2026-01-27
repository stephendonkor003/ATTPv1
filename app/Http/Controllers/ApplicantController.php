<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\ApplicantSubmissionReceived;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\ThinkDataset;

class ApplicantController extends Controller
{
    // public function index()
    // {


    //     $applicants = Applicant::latest()->paginate(10);
    //     return view('applicants.index', compact('applicants'));
    // }


  public function index()
{
    $user = Auth::user();

    if ($user->user_type === 'admin') {
        $applicants = Applicant::latest()->get();
    } elseif ($user->user_type === 'applicant') {
        $applicants = Applicant::where('code', $user->name)->latest()->get();
    } else {
        abort(403, 'Unauthorized access.');
    }

    // Process number of covered countries
    $applicants = $applicants->map(function ($applicant) {
        $countries = $applicant->covered_countries ? json_decode($applicant->covered_countries, true) : [];
        $applicant->covered_count = is_array($countries) ? count($countries) : 0;
        $applicant->covered_list  = is_array($countries) ? implode(', ', $countries) : '';
        return $applicant;
    });

    // Sort descending by covered_count
    $applicants = $applicants->sortByDesc('covered_count')->values();

    return view('applicants.index', [
        'applicants' => $applicants
    ]);
}



    // public function show(Applicant $applicant)
    // {
    //     return view('applicants.show', compact('applicant'));
    // }

    public function show($id)
    {
        $applicant = Applicant::findOrFail($id);
        return view('applicants.show', compact('applicant'));
    }

    public function edit(Applicant $applicant)
    {
        // optionally check user authorization
        return view('applicants.edit', compact('applicant'));
    }

    public function update(Request $request, Applicant $applicant)
    {
        $data = $request->except(['_token', '_method']);

        // Handle file uploads
        foreach ([
            'application_form', 'legal_registration', 'trustees_formation', 'audited_reports',
            'commitment_letter', 'work_plan_budget', 'cv_coordinator', 'cv_deputy',
            'cv_team_members', 'past_research'
        ] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('documents', 'public');
            }
        }

        // JSON encode array input
        if (isset($data['covered_countries'])) {
            $data['covered_countries'] = json_encode($data['covered_countries']);
        }

        $applicant->update($data);

        return redirect()->route('applicants.show', $applicant->id)->with('success', 'Submission updated successfully.');
    }


    public function create()
    {
        $thinkTanks = ThinkDataset::distinct()
            ->whereNotNull('tt_name_en')
            ->orderBy('tt_name_en')
            ->pluck('tt_name_en');

        return view('applicants.create', compact('thinkTanks'));

    }

    public function faq()
    {
        return view('applicants.faq');

    }
    public function events()
    {
        return view('events');

    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'think_tank_name' => 'required|string|max:255',
            'custom_think_tank' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'sub_region' => 'nullable|array',
            'focus_areas' => 'nullable|array',
            'email' => 'required|email|max:255',

            'consortium_name' => 'nullable|string|max:255',
            'members_names' => 'nullable|string|max:6000',
            'lead_think_tank_name' => 'nullable|string|max:255',
            'lead_think_tank_country' => 'nullable|string|max:255',
            'consortium_region' => 'nullable|string|max:255',
            'covered_countries' => 'nullable|array',

            'application_form' => 'nullable|file|mimes:pdf,doc,docx',
            'legal_registration' => 'nullable|file|mimes:pdf,doc,docx',
            'trustees_formation' => 'nullable|file|mimes:pdf,doc,docx',
            'audited_reports' => 'nullable|file|mimes:pdf,doc,docx',
            'commitment_letter' => 'nullable|file|mimes:pdf,doc,docx',
            'work_plan_budget' => 'nullable|file|mimes:pdf,doc,docx',
            'cv_coordinator' => 'nullable|file|mimes:pdf,doc,docx',
            'cv_deputy' => 'nullable|file|mimes:pdf,doc,docx',
            'cv_team_members' => 'nullable|file|mimes:pdf,doc,docx',
            'past_research' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $data = $validated;

        // Handle think_tank_name logic
        $selectedTank = $request->input('think_tank_name');
        $customTank = $request->input('custom_think_tank');
        $data['think_tank_name'] = $selectedTank === 'Other' && $customTank ? $customTank : $selectedTank;

        // Encode multi-select arrays
        $data['sub_region'] = $request->has('sub_region') ? json_encode($request->input('sub_region')) : null;
        $data['covered_countries'] = $request->has('covered_countries') ? json_encode($request->input('covered_countries')) : null;
        $data['focus_areas'] = $request->has('focus_areas') ? json_encode($request->input('focus_areas')) : null;

        // Handle file uploads
        foreach ([
            'application_form', 'legal_registration', 'trustees_formation',
            'audited_reports', 'commitment_letter', 'work_plan_budget',
            'cv_coordinator', 'cv_deputy', 'cv_team_members', 'past_research'
        ] as $fileField) {
            if ($request->hasFile($fileField)) {
                $data[$fileField] = $request->file($fileField)->store('applicants', 'public');
            }
        }

        try {
            // Generate unique applicant code
            $uniqueCode = 'AUC-TK-2-' . rand(100, 999);
            $data['code'] = $uniqueCode;

            // Save applicant
            $applicant = Applicant::create($data);

            // Create user account
            $defaultPassword = Str::random(8);

            try {
                $user = User::create([
                    'name' => $uniqueCode,
                    'email' => $applicant->email,
                    'password' => Hash::make($defaultPassword),
                    'user_type' => 'applicant',
                    'must_change_password' => true,
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                // Check if it's a duplicate email error
                if ($e->errorInfo[1] == 1062) {
                    $applicant->delete(); // Rollback applicant record
                    return redirect()->back()->withErrors(['error' => 'A Think Tank with this email already exists. Please try again later.']);
                }

                return redirect()->back()->withErrors(['error' => 'An unexpected database error occurred.']);
            }

            // Send confirmation email
            Mail::to($applicant->email)->send(new ApplicantSubmissionReceived($applicant, $uniqueCode, $defaultPassword));

            return redirect()->back()->with('success', 'Application submitted successfully. Login credentials have been sent to your email.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to save application. Please try again later.']);
        }
    }


    public function destroy(Applicant $applicant)
    {
        $applicant->delete();
        return redirect()->route('applicants.index')->with('success', 'Applicant deleted.');
    }
}
