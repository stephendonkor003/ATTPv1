<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;
use App\Models\Program;
use App\Models\ActivityAllocation;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display all activities (with project & program info)
     */
    public function index(Request $request)
{
    $search = $request->search;

    $programs = Program::with([
        'projects.activities.allocations' => function ($q) {
            $q->orderBy('year', 'asc');
        }
    ])
    ->when($search, function ($q) use ($search) {
        $q->where('name', 'like', "%$search%")
          ->orWhereHas('projects', function ($p) use ($search) {
              $p->where('name', 'like', "%$search%")
                ->orWhere('project_id', 'like', "%$search%");
          })
          ->orWhereHas('projects.activities', function ($a) use ($search) {
              $a->where('name', 'like', "%$search%");
          });
    })
    ->orderBy('name')
    ->get();

    return view('activities.index', compact('programs', 'search'));
}


    /**
     * Show create activity form
     */
    public function create(Project $project)
    {
        $project->load(['program', 'sector']);
        return view('activities.create', compact('project'));
    }


    /**
     * Store a new activity
     */
 public function store(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:myb_projects,id',
        'name'       => 'required|string|max:255',
    ]);

    $project = Project::findOrFail($request->project_id);

    // Create Activity
    $activity = Activity::create([
        'project_id'  => $request->project_id,
        'name'        => $request->name,
        'description' => $request->description,
        'created_by'  => auth()->id(),
    ]);

    /**
     * Save Allocation Amounts Submitted from the Blade
     * The Blade sends allocations[year] => amount
     */
    if ($request->has('allocations')) {

        foreach ($request->allocations as $year => $amount) {

            ActivityAllocation::create([
                'activity_id' => $activity->id,
                'year'        => $year,
                'amount'      => $amount !== null ? floatval($amount) : 0,
            ]);
        }

    } else {

        // Fallback — should never happen with your Blade
        foreach ($project->years() as $year) {
            ActivityAllocation::create([
                'activity_id' => $activity->id,
                'year'        => $year,
                'amount'      => 0,
            ]);
        }
    }

    return redirect()->route('budget.projects.show', $project->id)
                     ->with('success', 'Activity created successfully.');
}

    /**
     * Edit Activity Allocations
     */
    public function editAllocations($id)
    {
        $activity = Activity::with('allocations', 'project.program')->findOrFail($id);

        return view('activities.edit_allocations', compact('activity'));
    }

    /**
     * Update Activity Allocations
     */
    public function updateAllocations(Request $request, $id)
    {
        foreach ($request->allocations as $allocId => $amount) {
            ActivityAllocation::where('id', $allocId)->update([
                'amount' => $amount ?? 0
            ]);
        }

        return back()->with('success', 'Activity allocations updated successfully.');
    }


    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $activity = Activity::findOrFail($id);

    $activity->update([
        'name'        => $request->name,
        'description' => $request->description,
    ]);

    return redirect()
        ->route('budget.activities.index')
        ->with('success', 'Activity updated successfully.');
}


 public function show($id)
{
    $activity = Activity::with([
        'project.program',
        'project.sector',
        'allocations' => function ($q) {
            $q->orderBy('year', 'asc');
        }
    ])->findOrFail($id);

    $project = $activity->project;

    // Useful calculations for the blade
    $totalAllocation = $activity->allocations->sum('amount');
    $projectBudget   = $project->total_budget;
    $remainingBudget = $projectBudget - $totalAllocation;
    $percentageUsed  = $projectBudget > 0
                        ? ($totalAllocation / $projectBudget) * 100
                        : 0;

    return view('activities.show', compact(
        'activity',
        'project',
        'totalAllocation',
        'remainingBudget',
        'percentageUsed'
    ));
}


}