<?php

namespace App\Http\Controllers;

use App\Models\EvaluationCriteria;
use App\Models\EvaluationSection;
use Illuminate\Http\Request;

class EvaluationCriteriaController extends Controller
{
    /**
     * Store a new criteria under a section
     */
    public function store(Request $request, EvaluationSection $section)
    {
        if ($section->evaluation->status !== 'draft') {
            return back()->with('error', 'Cannot modify criteria once evaluation is active.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'max_score'   => 'required|integer|min:1',
        ]);

        $section->criteria()->create([
            'name'        => $request->name,
            'description' => $request->description,
            'max_score'   => $request->max_score,
        ]);

        return back()->with('success', 'Evaluation criteria added successfully.');
    }

    /**
     * Update a criteria
     */
    public function update(Request $request, EvaluationCriteria $criteria)
    {
        if ($criteria->section->evaluation->status !== 'draft') {
            return back()->with('error', 'Cannot modify criteria once evaluation is active.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_score'   => 'required|integer|min:1',
        ]);

        $criteria->update(
            $request->only('name', 'description', 'max_score')
        );

        return back()->with('success', 'Criteria updated successfully.');
    }

    /**
     * Delete a criteria
     */
    public function destroy(EvaluationCriteria $criteria)
    {
        if ($criteria->section->evaluation->status !== 'draft') {
            return back()->with('error', 'Cannot delete criteria once evaluation is active.');
        }

        $criteria->delete();

        return back()->with('success', 'Criteria removed successfully.');
    }
}
