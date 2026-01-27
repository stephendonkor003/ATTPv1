<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use App\Models\Program;
use App\Models\Project;
use App\Models\Activity;

use App\Exports\ProgramExport;
use App\Exports\ProjectExport;
use App\Exports\ActivityExport;

use Maatwebsite\Excel\Facades\Excel;
use PDF;

class BudgetReportController extends Controller
{
    /* ================================
       SECTOR OVERVIEW
    ================================== */
    public function index()
    {
        $sectors = Sector::with([
            'programs.projects.allocations',
            'programs.projects.activities.subActivities'
        ])->get();

        return view('budgetreport.index', compact('sectors'));
    }

    /* ================================
       PROGRAM REPORT
    ================================== */
    public function programReport($id)
    {
        $program = Program::with([
            'projects.allocations',
            'projects.activities.subActivities'
        ])->findOrFail($id);

        return view('budgetreport.program', compact('program'));
    }

    /* ================================
       PROJECT REPORT
    ================================== */
    public function projectReport($id)
    {
        $project = Project::with([
            'program',
            'allocations',
            'activities.allocations',
            'activities.subActivities'
        ])->findOrFail($id);

        return view('budgetreport.project', compact('project'));
    }

    /* ================================
       ACTIVITY REPORT
    ================================== */
    public function activityReport($id)
    {
        $activity = Activity::with([
            'project.program',
            'allocations',
            'subActivities.allocations'
        ])->findOrFail($id);

        return view('budgetreport.activity', compact('activity'));
    }


    /* ================================
       EXPORT: PDF
    ================================== */
    public function exportPDF($type, $id)
    {
        if ($type === 'program') {
            $data = Program::with('projects.activities.subActivities')->findOrFail($id);
            $view = 'exports.program_pdf';
        }

        if ($type === 'project') {
            $data = Project::with('activities.subActivities')->findOrFail($id);
            $view = 'exports.project_pdf';
        }

        if ($type === 'activity') {
            $data = Activity::with('subActivities')->findOrFail($id);
            $view = 'exports.activity_pdf';
        }

        $pdf = PDF::loadView($view, compact('data'))->setPaper('a4', 'portrait');

        return $pdf->download("$type-report-$id.pdf");
    }


    /* ================================
       EXPORT: EXCEL
    ================================== */
    public function exportExcel($type, $id)
    {
        if ($type === 'program') {
            return Excel::download(new ProgramExport($id), "program-$id.xlsx");
        }

        if ($type === 'project') {
            return Excel::download(new ProjectExport($id), "project-$id.xlsx");
        }

        if ($type === 'activity') {
            return Excel::download(new ActivityExport($id), "activity-$id.xlsx");
        }
    }


    /* ================================
       (OPTIONAL) DASHBOARD
    ================================== */
    public function dashboard()
    {
        $sectors = Sector::with([
            'programs.projects.allocations',
            'programs.projects.activities'
        ])->get();

        return view('budgetreport.dashboard', compact('sectors'));
    }
}