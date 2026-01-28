<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Project;
use App\Models\ProjectAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display list of projects
     */
    public function index()
    {
        $scopedNodeIds = $this->scopedNodeIds();
        if ($scopedNodeIds !== null && empty($scopedNodeIds)) {
            abort(403, 'You do not have access to projects.');
        }

        $projects = Project::with('program')
            ->when($scopedNodeIds !== null, function ($query) use ($scopedNodeIds) {
                $query->whereIn('governance_node_id', $scopedNodeIds)
                    ->whereNotNull('governance_node_id');
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        $programSummaries = Program::query()
            ->when($scopedNodeIds !== null, function ($query) use ($scopedNodeIds) {
                $query->whereIn('governance_node_id', $scopedNodeIds)
                    ->whereNotNull('governance_node_id');
            })
            ->withSum('projects', 'total_budget')
            ->orderBy('name')
            ->get()
            ->map(function ($program) {
                $used = (float) ($program->projects_sum_total_budget ?? 0);
                $total = (float) ($program->total_budget ?? 0);
                return (object) [
                    'program_id' => $program->program_id,
                    'name' => $program->name,
                    'currency' => $program->currency,
                    'total_budget' => $total,
                    'used_budget' => $used,
                    'remaining_budget' => max($total - $used, 0),
                ];
            });

        return view('projects.index', compact('projects', 'programSummaries'));
    }

    /**
     * Show create project form
     */
    public function create()
    {
        $programs = $this->availablePrograms();
        return view('projects.create', compact('programs'));
    }

    /**
     * Store new project
     */
    public function store(Request $request)
{
    $request->validate([
        'program_id'   => 'required|exists:myb_programs,id',
        'name'         => 'required|string|max:255',
        'expected_outcome_type' => 'required|in:percentage,text',
        'expected_outcome_percentage' => 'nullable|numeric|min:0|max:100',
        'expected_outcome_text' => 'nullable|string|max:2000',
        'start_year'   => 'required|integer',
        'end_year'     => 'required|integer|gte:start_year',
        'total_budget' => 'required|numeric|min:0',
        'description'  => 'nullable|string',
        'allocations'  => 'required|array',
        'allocations.*'=> 'numeric|min:0'
    ]);

    DB::beginTransaction();

    try {
        $program = Program::findOrFail($request->program_id);
        $this->assertProgramInScope($program);

        // Validate years
        if ($request->start_year < $program->start_year)
            return back()->with('error','Start year cannot be before program start year.')->withInput();

        if ($request->end_year > $program->end_year)
            return back()->with('error','End year cannot exceed program end year.')->withInput();

        if ($program->total_budget !== null && $request->total_budget > $program->total_budget) {
            return back()
                ->withErrors(['total_budget' => 'This project budget is higher than the program budget. Please enter an amount within the program total.'])
                ->withInput();
        }
        if ($program->total_budget !== null) {
            $existingTotal = Project::where('program_id', $program->id)->sum('total_budget');
            $remaining = $program->total_budget - $existingTotal;
            if (($existingTotal + (float) $request->total_budget) > $program->total_budget) {
                return back()
                    ->withErrors(['total_budget' => 'This program has only ' . ($program->currency ?? '') . ' ' . number_format(max($remaining, 0), 2) . ' remaining. Please lower the project budget.'])
                    ->withInput();
            }
        }

        $totalYears = $request->end_year - $request->start_year + 1;

        // Auto-generate Project ID
        $last = Project::where('program_id', $program->id)->latest('id')->first();
        $next = $last ? intval(substr($last->project_id, -2)) + 1 : 1;

        $projectId = $program->program_id . '-' . str_pad($next, 2, '0', STR_PAD_LEFT);

        // Create Project
        $expectedOutcomeValue = $request->expected_outcome_type === 'percentage'
            ? (string) ($request->expected_outcome_percentage ?? '')
            : ($request->expected_outcome_text ?? '');

        if ($request->expected_outcome_type === 'percentage' && $expectedOutcomeValue === '') {
            return back()->with('error', 'Expected outcome percentage is required.')->withInput();
        }

        if ($request->expected_outcome_type === 'text' && $expectedOutcomeValue === '') {
            return back()->with('error', 'Expected outcome description is required.')->withInput();
        }

        $project = Project::create([
            'program_id'   => $program->id,
            'project_id'   => $projectId,
            'governance_node_id' => $program->governance_node_id,
            'name'         => $request->name,
            'description'  => $request->description,
            'expected_outcome_type' => $request->expected_outcome_type,
            'expected_outcome_value' => $expectedOutcomeValue,
            'currency'     => $program->currency,
            'start_year'   => $request->start_year,
            'end_year'     => $request->end_year,
            'total_years'  => $totalYears,
            'total_budget' => $request->total_budget,
            'created_by'   => auth()->id(),
        ]);

        // Save Allocations
        $yearNumber = 1;
        foreach ($request->allocations as $actualYear => $amount) {

            ProjectAllocation::create([
                'project_id'  => $project->id,
                'year'        => $actualYear,        // REQUIRED BY YOUR TABLE
                'year_number' => $yearNumber,        // 1,2,3, etc
                'actual_year' => $actualYear,        // calendar year
                'amount'      => $amount ?? 0
            ]);

            $yearNumber++;
        }

        DB::commit();
        return redirect()->route('budget.projects.index')->with('success', 'Project created successfully.');

    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
    }
}



    /**
     * Show project details
     */
    public function show($id)
    {
        $project = Project::with('program', 'allocations')->findOrFail($id);
        $this->assertProjectInScope($project);
        return view('projects.show', compact('project'));
    }

    /**
     * Edit project
     */
    public function edit($id)
    {
        $project  = Project::with('allocations')->findOrFail($id);
        $this->assertProjectInScope($project);
        $programs = $this->availablePrograms();

        return view('projects.edit', compact('project', 'programs'));
    }

    /**
     * Update project
     */
public function update(Request $request, $id)
{
    $project = Project::findOrFail($id);
    $this->assertProjectInScope($project);
    $program = Program::findOrFail($request->program_id);
    $this->assertProgramInScope($program);

    // Validation
    $request->validate([
        'program_id'   => 'required|exists:myb_programs,id',
        'name'         => 'required|string|max:255',
        'expected_outcome_type' => 'required|in:percentage,text',
        'expected_outcome_percentage' => 'nullable|numeric|min:0|max:100',
        'expected_outcome_text' => 'nullable|string|max:2000',
        'start_year'   => 'required|integer',
        'end_year'     => 'required|integer|gte:start_year',
        'total_budget' => 'required|numeric|min:0',
        'description'  => 'nullable|string',
    ]);

    // Validate years inside program range
    if ($request->start_year < $program->start_year) {
        return back()->with('error', 'Project start year cannot be earlier than program start year.')
            ->withInput();
    }

    if ($request->end_year > $program->end_year) {
        return back()->with('error', 'Project end year cannot exceed program end year.')
            ->withInput();
    }

    if ($program->total_budget !== null && $request->total_budget > $program->total_budget) {
        return back()
            ->withErrors(['total_budget' => 'This project budget is higher than the program budget. Please enter an amount within the program total.'])
            ->withInput();
    }
    if ($program->total_budget !== null) {
        $existingTotal = Project::where('program_id', $program->id)
            ->where('id', '!=', $project->id)
            ->sum('total_budget');
        $remaining = $program->total_budget - $existingTotal;
        if (($existingTotal + (float) $request->total_budget) > $program->total_budget) {
            return back()
                ->withErrors(['total_budget' => 'This program has only ' . ($program->currency ?? '') . ' ' . number_format(max($remaining, 0), 2) . ' remaining. Please lower the project budget.'])
                ->withInput();
        }
    }

    DB::beginTransaction();

    try {
        // Update project
        $totalYears = $request->end_year - $request->start_year + 1;

        $expectedOutcomeValue = $request->expected_outcome_type === 'percentage'
            ? (string) ($request->expected_outcome_percentage ?? '')
            : ($request->expected_outcome_text ?? '');

        if ($request->expected_outcome_type === 'percentage' && $expectedOutcomeValue === '') {
            return back()->with('error', 'Expected outcome percentage is required.')->withInput();
        }

        if ($request->expected_outcome_type === 'text' && $expectedOutcomeValue === '') {
            return back()->with('error', 'Expected outcome description is required.')->withInput();
        }

        $project->update([
            'program_id'   => $program->id,
            'name'         => $request->name,
            'description'  => $request->description,
            'expected_outcome_type' => $request->expected_outcome_type,
            'expected_outcome_value' => $expectedOutcomeValue,
            'currency'     => $program->currency,
            'start_year'   => $request->start_year,
            'end_year'     => $request->end_year,
            'total_years'  => $totalYears,
            'total_budget' => $request->total_budget,
            'governance_node_id' => $program->governance_node_id,
        ]);

        // Remove old allocations
        ProjectAllocation::where('project_id', $project->id)->delete();

        // Insert updated allocations
        foreach ($request->allocations as $year => $amount) {
            $yearNumber = $year - $project->start_year + 1;

            ProjectAllocation::create([
                'project_id'   => $project->id,
                'year'         => $year,
                'year_number'  => $yearNumber,
                'actual_year'  => $year,
                'amount'       => $amount ?? 0,
            ]);
        }

        DB::commit();
        return redirect()->route('budget.projects.index')->with('success', 'Project updated successfully.');

    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
    }
}

    /**
     * Delete project
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $this->assertProjectInScope($project);

        DB::beginTransaction();

        try {

            ProjectAllocation::where('project_id', $id)->delete();
            $project->delete();

            DB::commit();

            return redirect()->route('budget.projects.index')
                ->with('success', 'Project deleted successfully.');

        } catch (\Throwable $e) {

            DB::rollBack();
            return back()->with('error', 'Unable to delete project: ' . $e->getMessage());
        }
    }

    /**
     * Analytics Dashboard
     */
    public function analytics()
    {
        $totalProjects = Project::count();
        $totalPrograms = Program::count();
        $totalBudget   = Program::sum('total_budget');
        $totalAlloc    = ProjectAllocation::sum('amount');

        // Sector Distribution
        $sectorDistribution = Program::selectRaw('sector_id, SUM(total_budget) as budget')
            ->groupBy('sector_id')
            ->with('sector')
            ->get();

        // Yearly Trend using actual_year
        $yearlyTrend = ProjectAllocation::selectRaw('actual_year, SUM(amount) as total')
            ->groupBy('actual_year')
            ->orderBy('actual_year')
            ->get();

        // Top projects
        $topProjects = Project::orderBy('total_budget', 'DESC')
            ->take(5)
            ->get();

        return view('budget.projects.analytics', compact(
            'totalProjects',
            'totalPrograms',
            'totalBudget',
            'totalAlloc',
            'sectorDistribution',
            'yearlyTrend',
            'topProjects'
        ));
    }

    private function scopedNodeIds(): ?array
    {
        $currentUser = Auth::user();

        if (!$currentUser || $currentUser->isAdmin()) {
            return null;
        }

        if (!$currentUser->governance_node_id) {
            return [];
        }

        return [$currentUser->governance_node_id];
    }

    private function availablePrograms()
    {
        $scopedNodeIds = $this->scopedNodeIds();

        $query = Program::orderBy('name');

        if ($scopedNodeIds !== null) {
            $query->whereIn('governance_node_id', $scopedNodeIds)
                ->whereNotNull('governance_node_id');
        }

        return $query->get();
    }

    private function assertProjectInScope(Project $project): void
    {
        $scopedNodeIds = $this->scopedNodeIds();
        if ($scopedNodeIds === null) {
            return;
        }

        if (!$project->governance_node_id || !in_array($project->governance_node_id, $scopedNodeIds, true)) {
            abort(403, 'You do not have access to this project.');
        }
    }

    private function assertProgramInScope(Program $program): void
    {
        $scopedNodeIds = $this->scopedNodeIds();
        if ($scopedNodeIds === null) {
            return;
        }

        if (!$program->governance_node_id || !in_array($program->governance_node_id, $scopedNodeIds, true)) {
            abort(403, 'You do not have access to this program.');
        }
    }
}
