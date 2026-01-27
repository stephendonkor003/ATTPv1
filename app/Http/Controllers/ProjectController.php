<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Project;
use App\Models\ProjectAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display list of projects
     */
    public function index()
    {
        $projects = Project::with('program')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show create project form
     */
    public function create()
    {
        $programs = Program::orderBy('name')->get();
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

        // Validate years
        if ($request->start_year < $program->start_year)
            return back()->with('error','Start year cannot be before program start year.')->withInput();

        if ($request->end_year > $program->end_year)
            return back()->with('error','End year cannot exceed program end year.')->withInput();

        $totalYears = $request->end_year - $request->start_year + 1;

        // Auto-generate Project ID
        $last = Project::where('program_id', $program->id)->latest('id')->first();
        $next = $last ? intval(substr($last->project_id, -2)) + 1 : 1;

        $projectId = $program->program_id . '-' . str_pad($next, 2, '0', STR_PAD_LEFT);

        // Create Project
        $project = Project::create([
            'program_id'   => $program->id,
            'project_id'   => $projectId,
            'name'         => $request->name,
            'description'  => $request->description,
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
        return view('projects.show', compact('project'));
    }

    /**
     * Edit project
     */
    public function edit($id)
    {
        $project  = Project::with('allocations')->findOrFail($id);
        $programs = Program::orderBy('name')->get();

        return view('projects.edit', compact('project', 'programs'));
    }

    /**
     * Update project
     */
     public function update(Request $request, $id)
{
    $project = Project::findOrFail($id);
    $program = Program::findOrFail($request->program_id);

    // Validation
    $request->validate([
        'program_id'   => 'required|exists:myb_programs,id',
        'name'         => 'required|string|max:255',
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

    DB::beginTransaction();

    try {
        // Update project
        $totalYears = $request->end_year - $request->start_year + 1;

        $project->update([
            'program_id'   => $program->id,
            'name'         => $request->name,
            'description'  => $request->description,
            'currency'     => $program->currency,
            'start_year'   => $request->start_year,
            'end_year'     => $request->end_year,
            'total_years'  => $totalYears,
            'total_budget' => $request->total_budget,
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

        DB::beginTransaction();

        try {

            ProjectAllocation::where('project_id', $id)->delete();
            $project->delete();

            DB::commit();

            return redirect()->route('projects.index')
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
}
