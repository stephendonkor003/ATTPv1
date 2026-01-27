<?php

namespace App\Http\Controllers;

use App\Models\HrApplicant;
use App\Models\HrVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HrPublicController extends Controller
{
    /**
     * Public careers page
     */
    // public function index()
    // {
    //     $vacancies = HrVacancy::where('status', 'published')
    //         ->latest()
    //         ->get();

    //     return view('public.careers.index', compact('vacancies'));
    // }

    public function index()
{
    $vacancies = HrVacancy::with('position') // 👈 REQUIRED
        ->where('status', 'published')
        ->where('is_public', true) // optional but recommended
        ->latest()
        ->get();

    return view('public.careers.index', compact('vacancies'));
}


    /**
     * Store public job application
     */
    public function storeApplication(Request $request)
    {
        $validated = $request->validate([
            'vacancy_id'   => 'required|exists:hr_vacancies,id',
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|string|max:50',
            'resume'       => 'required|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $resumePath = $request->file('resume')
            ->store('hr/applications/cv', 'public');

        $coverPath = $request->hasFile('cover_letter')
            ? $request->file('cover_letter')
                ->store('hr/applications/cover_letters', 'public')
            : null;

        HrApplicant::create([
            'vacancy_id'        => $validated['vacancy_id'],
            'full_name'         => $validated['full_name'],
            'email'             => $validated['email'],
            'phone'             => $validated['phone'],
            'cv_path'           => $resumePath,
            'cover_letter_path' => $coverPath,
            'status'            => 'applied',
        ]);

        return back()->with('success', 'Application submitted successfully.');
    }
}