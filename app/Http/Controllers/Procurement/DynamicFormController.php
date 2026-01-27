<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\DynamicForm;
use App\Models\Resource;
use App\Models\Procurement;
use Illuminate\Http\Request;

class DynamicFormController extends Controller
{
    /**
     * List all procurement forms
     */
    // public function index()
    // {
    //     $forms = DynamicForm::with('resource')
    //         ->orderByDesc('created_at')
    //         ->get();

    //     return view('procurement.forms.index', compact('forms'));
    // }

    public function index()
    {
        $forms = DynamicForm::with('resource')
            ->latest()
            ->get();

        $resources = Resource::orderBy('name')->get();

        $procurements = Procurement::orderBy('title')->get(); // 👈 REQUIRED

        return view('procurement.forms.index', compact(
            'forms',
            'resources',
            'procurements'
        ));
    }



    /**
     * Show create form page
     */
    public function create()
    {
        $resources = Resource::orderBy('name')->get();

        return view('procurement.forms.create', compact('resources'));
    }

    /**
     * Store new procurement form
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'resource_id' => 'required|exists:myb_resources,id',
            'name'        => 'required|string|max:255',
            'applies_to'  => 'required|in:submission,prescreening,technical,financial',
        ]);

        $data['created_by'] = auth()->id();
        $data['status']     = 'draft';
        $data['is_active']  = 0; // only active AFTER approval

        $form = DynamicForm::create($data);

        return redirect()
            ->route('forms.edit', $form->id)
            ->with('success', 'Procurement form created. You can now add fields.');
    }

    /**
     * Edit form + manage fields
     */
    public function edit(DynamicForm $form)
    {
        $form->load('fields');
        $resources = Resource::orderBy('name')->get();

        return view('procurement.forms.edit', compact('form', 'resources'));
    }

    /**
     * Submit form for approval
     */
    public function submit(DynamicForm $form)
    {
        if (!$form->canEdit()) {
            return back()->with('error', 'This form cannot be submitted in its current state.');
        }

        if ($form->fields()->count() === 0) {
            return back()->with('error', 'You must add at least one field before submitting.');
        }

        $form->update([
            'status'       => 'submitted',
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Form submitted for approval.');
    }

    /**
     * Approve a submitted form
     */
    public function approve(DynamicForm $form)
    {
        if ($form->status !== 'submitted') {
            return back()->with('error', 'Only submitted forms can be approved.');
        }

        $form->update([
            'status'      => 'approved',
            'is_active'   => 1,
            'approved_at'=> now(),
            'approved_by'=> auth()->id(),
        ]);

        return back()->with('success', 'Form approved and activated successfully.');
    }

    /**
     * Reject a submitted form
     */
    public function reject(Request $request, DynamicForm $form)
    {
        if ($form->status !== 'submitted') {
            return back()->with('error', 'Only submitted forms can be rejected.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|min:5',
        ]);

        $form->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'is_active'        => 0,
        ]);

        return back()->with('success', 'Form rejected and returned for correction.');
    }


    /**
     * Attach a dynamic form to a procurement
     */
    public function attachForm(Request $request)
    {
        $request->validate([
            'form_id'        => 'required|exists:dynamic_forms,id',
            'procurement_id' => 'required|exists:procurements,id',
        ]);

        $procurement = Procurement::findOrFail($request->procurement_id);

        // ✅ Prevent duplicate attachment
        if ($procurement->forms()
            ->where('dynamic_form_id', $request->form_id)
            ->exists()) {

            return back()->with('error', 'This form is already attached to the selected procurement.');
        }

        // ✅ Attach form
        $procurement->forms()->attach($request->form_id, [
            'attached_by' => auth()->id(),
            'attached_at' => now(),
        ]);

        return back()->with('success', 'Form attached to procurement successfully.');
    }
}