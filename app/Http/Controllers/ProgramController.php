<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    /**
     * PROGRAM RBAC
     * Matches routes:
     * permission:budget.structure.manage
     */
     public function __construct()
    {
        $this->middleware(['auth', 'verified']);

        $this->middleware('permission:program.view')
            ->only(['index', 'show']);

        $this->middleware('permission:program.create')
            ->only(['create', 'store']);

        $this->middleware('permission:program.edit')
            ->only(['edit', 'update']);

        $this->middleware('permission:program.delete')
            ->only(['destroy']);
    }


    /**
     * List all programs
     */
    public function index()
    {
        $programs = Program::with('sector')
            ->latest()
            ->paginate(15);

        return view('budget.programs.index', compact('programs'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $sectors = Sector::orderBy('name')->get();
        return view('budget.programs.create', compact('sectors'));
    }

    /**
     * Store Program
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sector_id'   => 'required|exists:myb_sectors,id',
            'program_id'  => 'required|string|max:50|unique:myb_programs,program_id',
            'name'        => 'required|string|max:255',
            'currency'    => 'required|string|max:10',
            'start_year'  => 'required|integer|min:1900|max:2100',
            'end_year'    => 'required|integer|min:1900|max:2100|gte:start_year',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $validated['total_years'] =
                ($validated['end_year'] - $validated['start_year']) + 1;

            $validated['created_by'] = auth()->id();

            Program::create($validated);

            DB::commit();

            return redirect()
                ->route('budget.programs.index')
                ->with('success', 'Program created successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Failed to create program: ' . $e->getMessage());
        }
    }

    /**
     * Show a single program
     */
    public function show(Program $program)
    {
        $program->load([
            'sector',
            'projects.activities.subActivities'
        ]);

        return view('budget.programs.show', compact('program'));
    }

    /**
     * Edit program
     */
    public function edit(Program $program)
    {
        $sectors = Sector::orderBy('name')->get();
        return view('budget.programs.edit', compact('program', 'sectors'));
    }

    /**
     * Update program
     */
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'sector_id'   => 'required|exists:myb_sectors,id',
            'name'        => 'required|string|max:255',
            'currency'    => 'required|string|max:10',
            'start_year'  => 'required|integer|min:1900|max:2100',
            'end_year'    => 'required|integer|min:1900|max:2100|gte:start_year',
            'description' => 'nullable|string',
        ]);

        $validated['total_years'] =
            ($validated['end_year'] - $validated['start_year']) + 1;

        $validated['updated_by'] = auth()->id();

        $program->update($validated);

        return redirect()
            ->route('programs.index')
            ->with('success', 'Program updated successfully.');
    }

    /**
     * Delete program (cascade-safe)
     */
    public function destroy(Program $program)
    {
        DB::beginTransaction();

        try {
            foreach ($program->projects as $project) {
                foreach ($project->activities as $activity) {
                    foreach ($activity->subActivities as $sub) {
                        $sub->allocations()?->delete();
                        $sub->delete();
                    }

                    $activity->allocations()?->delete();
                    $activity->delete();
                }

                $project->allocations()?->delete();
                $project->delete();
            }

            $program->delete();

            DB::commit();

            return back()->with('success', 'Program deleted successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
