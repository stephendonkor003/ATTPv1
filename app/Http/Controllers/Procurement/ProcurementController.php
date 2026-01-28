<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\Procurement;
use App\Models\Resource;
use App\Models\DynamicForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Procurement\Concerns\GovernanceScope;

class ProcurementController extends Controller
{
    use GovernanceScope;

    /**
     * List all procurements
     */
    public function index()
{
    $scopedNodeIds = $this->scopedNodeIds();
    if ($scopedNodeIds !== null && empty($scopedNodeIds)) {
        abort(403, 'You do not have access to procurements.');
    }

    $procurements = $this->applyProcurementScope(
        Procurement::withCount('forms')
    )
        ->orderByDesc('created_at')
        ->paginate(10); // ✅ FIX

    return view('procurement.index', compact('procurements'));
}


    /**
     * Show create procurement form
     */
    public function create()
    {
        $scopedNodeIds = $this->scopedNodeIds();
        if ($scopedNodeIds !== null && empty($scopedNodeIds)) {
            abort(403, 'You do not have access to create procurements.');
        }

        $resources = Resource::orderBy('name')
            ->when($this->scopedNodeIds() !== null, function ($query) {
                $query->whereIn('governance_node_id', $this->scopedNodeIds())
                    ->whereNotNull('governance_node_id');
            })
            ->get();

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

    $resource = Resource::findOrFail($data['resource_id']);
    $this->assertResourceInScope($resource);

    $data['created_by'] = auth()->id();
    $data['status']     = 'draft';
    $data['governance_node_id'] = $resource->governance_node_id;

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
        $this->assertProcurementInScope($procurement);
        $procurement->load([
            'resource',
            'forms.resource',
            'forms.creator',
        ]);

        $availableForms = DynamicForm::approved()
            ->whereNull('procurement_id')
            ->when($procurement->governance_node_id, function ($query) use ($procurement) {
                $query->whereHas('resource', function ($res) use ($procurement) {
                    $res->where('governance_node_id', $procurement->governance_node_id);
                });
            })
            ->orderBy('name')
            ->get();

        return view('procurement.show', compact('procurement', 'availableForms'));
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
        $procurement = Procurement::findOrFail($request->procurement_id);
        $this->assertProcurementInScope($procurement);
        if ($procurement->governance_node_id && $form->resource?->governance_node_id !== $procurement->governance_node_id) {
            abort(403, 'You do not have access to attach this form to the selected procurement.');
        }

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
