<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use App\Models\DynamicForm;
use App\Models\ProcurementFormAssignment;
use Illuminate\Http\Request;

class ProcurementFormAssignmentController extends Controller
{
    /**
     * Show form attachment page
     */
    public function create(Procurement $procurement)
    {
        $forms = DynamicForm::approved()
            ->orderBy('name')
            ->get();

        return view('procurement.forms.attach', compact(
            'procurement',
            'forms'
        ));
    }

    /**
     * Attach form to procurement
     */
    public function store(Request $request, Procurement $procurement)
    {
        $data = $request->validate([
            'form_id' => 'required|exists:dynamic_forms,id',
            'stage'   => 'required|in:submission,prescreening,technical,financial',
        ]);

        // Ensure form is approved
        $form = DynamicForm::approved()->findOrFail($data['form_id']);

        ProcurementFormAssignment::updateOrCreate(
            [
                'procurement_id' => $procurement->id,
                'stage' => $data['stage'],
            ],
            [
                'form_id'    => $form->id,
                'created_by' => auth()->id(),
            ]
        );

        return back()->with('success', 'Form attached successfully.');
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