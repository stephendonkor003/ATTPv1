<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use App\Models\Resource;
use App\Models\DynamicForm;
use Illuminate\Http\Request;

class ProcurementController extends Controller
{
    /**
     * List all procurements
     */
    public function index()
{
    $procurements = Procurement::withCount('forms')
        ->orderByDesc('created_at')
        ->paginate(10); // ✅ FIX

    return view('procurement.index', compact('procurements'));
}


    /**
     * Show create procurement form
     */
    public function create()
    {
        $resources = Resource::orderBy('name')->get();

        return view('procurement.create', compact('resources'));
    }

    /**
     * Store procurement
     */
  public function store(Request $request)
{
    $data = $request->validate([
        'resource_id'       => 'required|exists:myb_resources,id',
        'title'             => 'required|string|max:255',
        'description'       => 'required|string',
        'fiscal_year'       => 'required|string|max:20',
        'reference_no'      => 'nullable|unique:procurements,reference_no',
        'estimated_budget'  => 'nullable|numeric',
    ]);

    $data['created_by'] = auth()->id();
    $data['status']     = 'draft';

    Procurement::create($data);

    return redirect()
        ->route('procurements.index')
        ->with('success', 'Procurement created successfully.');
}


    /**
     * Show procurement details
     */
    public function show(Procurement $procurement)
    {
        $procurement->load([
            'resource',
            'forms.resource',
            'forms.creator',
        ]);

        return view('procurement.show', compact('procurement'));
    }

    /**
     * Attach a dynamic form to a procurement
     * (ONE FORM → ONE PROCUREMENT)
     */
    public function attachForm(Request $request)
    {
        $request->validate([
            'form_id'        => 'required|exists:dynamic_forms,id',
            'procurement_id' => 'required|exists:procurements,id',
        ]);

        $form = DynamicForm::findOrFail($request->form_id);

        // ❗ Prevent re-attaching
        if ($form->procurement_id !== null) {
            return back()->with(
                'error',
                'This form is already attached to a procurement.'
            );
        }

        $form->update([
            'procurement_id' => $request->procurement_id,
        ]);

        return back()->with(
            'success',
            'Form successfully attached to the procurement.'
        );
    }
}