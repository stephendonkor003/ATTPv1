<?php

namespace App\Http\Controllers;

use App\Models\PrescreeningTemplate;
use App\Models\PrescreeningCriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescreeningTemplateController extends Controller
{
    /**
     * List templates
     */
    public function index()
    {
        $templates = PrescreeningTemplate::withCount('criteria')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('prescreening.templates.index', compact('templates'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('prescreening.templates.create');
    }

    /**
     * Store template + criteria
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                        => 'required|string|max:255',
            'description'                 => 'nullable|string',
            'is_active'                   => 'nullable|boolean',

            'criteria'                    => 'required|array|min:1',
            'criteria.*.name'             => 'required|string|max:255',
            'criteria.*.field_key'        => 'required|string|max:191',
            'criteria.*.evaluation_type'  => 'required|in:yes_no,exists,numeric',
            'criteria.*.min_value'        => 'nullable|numeric',
            'criteria.*.is_mandatory'     => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated) {

            $template = PrescreeningTemplate::create([
                'name'        => $validated['name'],
                'description' => $validated['description'] ?? null,
                'is_active'   => $validated['is_active'] ?? false,
                'created_by'  => auth()->id(),
            ]);

            foreach ($validated['criteria'] as $index => $criterion) {
                PrescreeningCriterion::create([
                    'prescreening_template_id' => $template->id,
                    'name'            => $criterion['name'],
                    'field_key'       => $criterion['field_key'],
                    'evaluation_type' => $criterion['evaluation_type'],
                    'min_value'       => $criterion['min_value'] ?? null,
                    'is_mandatory'    => $criterion['is_mandatory'] ?? false,
                    'sort_order'      => $index + 1,
                ]);
            }
        });

        return redirect()
            ->route('prescreening.templates.index')
            ->with('success', 'Prescreening template created successfully.');
    }

    /**
     * Show template (read-only)
     */
    public function show(PrescreeningTemplate $template)
    {
        $template->load('criteria');

        return view('prescreening.templates.show', compact('template'));
    }

    /**
     * Show edit form
     */
    public function edit(PrescreeningTemplate $template)
    {
        $template->load('criteria');

        return view('prescreening.templates.edit', compact('template'));
    }

    /**
     * Update template + criteria
     */
    public function update(Request $request, PrescreeningTemplate $template)
    {
        $validated = $request->validate([
            'name'                        => 'required|string|max:255',
            'description'                 => 'nullable|string',
            'is_active'                   => 'nullable|boolean',

            'criteria'                    => 'required|array|min:1',
            'criteria.*.name'             => 'required|string|max:255',
            'criteria.*.field_key'        => 'required|string|max:191',
            'criteria.*.evaluation_type'  => 'required|in:yes_no,exists,numeric',
            'criteria.*.min_value'        => 'nullable|numeric',
            'criteria.*.is_mandatory'     => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated, $template) {

            // Update template
            $template->update([
                'name'        => $validated['name'],
                'description' => $validated['description'] ?? null,
                'is_active'   => $validated['is_active'] ?? false,
            ]);

            // Remove old criteria
            $template->criteria()->delete();

            // Recreate criteria
            foreach ($validated['criteria'] as $index => $criterion) {
                PrescreeningCriterion::create([
                    'prescreening_template_id' => $template->id,
                    'name'            => $criterion['name'],
                    'field_key'       => $criterion['field_key'],
                    'evaluation_type' => $criterion['evaluation_type'],
                    'min_value'       => $criterion['min_value'] ?? null,
                    'is_mandatory'    => $criterion['is_mandatory'] ?? false,
                    'sort_order'      => $index + 1,
                ]);
            }
        });

        return redirect()
            ->route('prescreening.templates.show', $template)
            ->with('success', 'Prescreening template updated successfully.');
    }
}