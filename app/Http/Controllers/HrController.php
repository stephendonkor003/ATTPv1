<?php

namespace App\Http\Controllers;

use App\Models\{
    HrPosition,
    HrVacancy,
    HrApplicant,
    HrEmployee,
    Resource
};
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HrController extends Controller
{
    /* =====================================================
        POSITIONS
    ===================================================== */

    public function positions()
    {
        $positions = HrPosition::with('resource')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hr.positions.index', compact('positions'));
    }

    public function storePosition(Request $request)
    {
        $validated = $request->validate([
            'resource_id'     => 'required|exists:myb_resources,id',
            'title'           => 'required|string|max:255',
            'employment_type' => 'required|in:permanent,contract,temporary,consultant',
            'grade_level'     => 'nullable|string|max:50',
            'description'     => 'nullable|string',
        ]);

        // Enforce HR-only resources
        $isHrResource = Resource::where('id', $validated['resource_id'])
            ->where('is_human_resource', 1)
            ->exists();

        abort_unless($isHrResource, 403, 'Selected resource is not HR-enabled.');

        HrPosition::create([
            ...$validated,
            'status'     => 'active',
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'Position created successfully.');
    }

    /* =====================================================
        VACANCIES
    ===================================================== */

    public function vacancies()
    {
        $vacancies = HrVacancy::with('position.resource')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hr.vacancies.index', compact('vacancies'));
    }

    public function storeVacancy(Request $request)
    {
        $validated = $request->validate([
            'position_id'         => 'required|exists:hr_positions,id',
            'open_date'           => 'required|date',
            'close_date'          => 'required|date|after:open_date',
            'number_of_positions' => 'required|integer|min:1',
            'is_public'           => 'nullable|boolean',
        ]);

        HrVacancy::create([
            'position_id'         => $validated['position_id'],
            'vacancy_code'        => 'VAC-' . strtoupper(Str::random(6)),
            'open_date'           => $validated['open_date'],
            'close_date'          => $validated['close_date'],
            'number_of_positions' => $validated['number_of_positions'],
            'is_public'           => $request->boolean('is_public'),
            'status'              => 'draft',
            'created_by'          => Auth::id(),
        ]);

        return back()->with('success', 'Vacancy created as draft.');
    }

    public function submitVacancyForApproval(HrVacancy $vacancy)
    {
        abort_if($vacancy->status !== 'draft', 400, 'Only draft vacancies can be submitted.');

        $vacancy->update(['status' => 'submitted']);

        return back()->with('success', 'Vacancy submitted for approval.');
    }

    public function approveVacancy(HrVacancy $vacancy)
    {
        abort_if($vacancy->status !== 'submitted', 400, 'Vacancy must be submitted first.');

        $vacancy->update([
            'status'      => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Vacancy approved.');
    }

    public function publishVacancy(HrVacancy $vacancy)
    {
        abort_if($vacancy->status !== 'approved', 400, 'Vacancy must be approved.');

        $vacancy->update(['status' => 'published']);

        return back()->with('success', 'Vacancy published publicly.');
    }

    public function closeVacancy(HrVacancy $vacancy)
    {
        abort_if(!in_array($vacancy->status, ['published','approved']), 400);

        $vacancy->update(['status' => 'closed']);

        return back()->with('success', 'Vacancy closed.');
    }

    /* =====================================================
        APPLICANTS
    ===================================================== */

    public function applicants(HrVacancy $vacancy)
    {
        $applicants = HrApplicant::where('vacancy_id', $vacancy->id)
            ->orderBy('submitted_at', 'desc')
            ->get();

        return view('hr.applicants.index', compact('vacancy', 'applicants'));
    }

    /* =====================================================
        AI APPLICANT SCORING
    ===================================================== */

    protected function aiScoreApplicant(HrApplicant $applicant): float
    {
        // Simple deterministic AI-style heuristic
        $score = 0;

        if ($applicant->cv_path) {
            $score += 40;
        }

        if ($applicant->cover_letter_path) {
            $score += 20;
        }

        if ($applicant->nationality) {
            $score += 10;
        }

        if ($applicant->phone) {
            $score += 10;
        }

        return min($score, 100);
    }

    public function scoreApplicantAI(HrApplicant $applicant)
    {
        abort_if($applicant->status !== 'applied', 400, 'Applicant already processed.');

        DB::transaction(function () use ($applicant) {

            $score = $this->aiScoreApplicant($applicant);

            DB::table('hr_shortlists')->insert([
                'applicant_id'   => $applicant->id,
                'stage'          => 'screening',
                'score'          => $score,
                'remarks'        => 'AI auto-screening score',
                'shortlisted_by' => Auth::id(),
                'shortlisted_at' => now(),
            ]);

            $applicant->update(['status' => 'scored']);
        });

        return back()->with('success', 'Applicant scored by AI.');
    }

    public function shortlistApplicant(HrApplicant $applicant)
    {
        abort_if($applicant->status !== 'scored', 400, 'Applicant must be scored first.');

        $applicant->update(['status' => 'shortlisted']);

        return back()->with('success', 'Applicant shortlisted.');
    }

    /* =====================================================
        HIRING / EMPLOYEES
    ===================================================== */

    // public function hireApplicant(HrApplicant $applicant)
    // {
    //     abort_if($applicant->status !== 'shortlisted', 400, 'Applicant must be shortlisted.');

    //     DB::transaction(function () use ($applicant) {

    //         HrEmployee::create([
    //             'applicant_id'            => $applicant->id,
    //             'position_id'             => $applicant->vacancy->position_id,
    //             'employee_code'           => 'EMP-' . strtoupper(Str::random(6)),
    //             'employment_start_date'   => now(),
    //             'contract_type'           => $applicant->vacancy->position->employment_type,
    //             'status'                  => 'active',
    //         ]);

    //         $applicant->update(['status' => 'hired']);
    //     });

    //     return back()->with('success', 'Applicant hired successfully.');
    // }




// public function hireApplicant(HrApplicant $applicant)
// {
//     abort_if($applicant->status !== 'shortlisted', 400, 'Applicant must be shortlisted.');

//     DB::transaction(function () use ($applicant) {

//         /* ===============================
//          | 1. CREATE USER ACCOUNT
//          =============================== */
//         $plainPassword = Str::random(10);

//         $user = User::create([
//             'name'                  => $applicant->full_name,
//             'email'                 => $applicant->email,
//             'password'              => Hash::make($plainPassword),
//             'user_type'             => 'employee',
//             'must_change_password'  => true,
//         ]);

//         /* ===============================
//          | 2. CREATE EMPLOYEE RECORD
//          =============================== */
//         HrEmployee::create([
//             'user_id'                 => $user->id,
//             'applicant_id'            => $applicant->id,
//             'position_id'             => $applicant->vacancy->position_id,
//             'employee_code'           => 'EMP-' . strtoupper(Str::random(6)),
//             'employment_start_date'   => now(),
//             'contract_type'           => $applicant->vacancy->position->employment_type,
//             'status'                  => 'active',
//         ]);

//         /* ===============================
//          | 3. UPDATE APPLICANT STATUS
//          =============================== */
//         $applicant->update(['status' => 'hired']);

//         /* ===============================
//          | 4. SEND EMAIL
//          =============================== */
//         Mail::send('emails.hr.employee-welcome', [
//             'name'     => $user->name,
//             'email'    => $user->email,
//             'password' => $plainPassword,
//             'userType' => 'Employee',
//         ], function ($message) use ($user) {
//             $message->to($user->email)
//                     ->subject('🎉 Congratulations! You Have Been Hired');
//         });
//     });

//     return back()->with('success', 'Applicant hired successfully and login credentials sent.');
// }





public function hireApplicant(HrApplicant $applicant)
{
    try {

        /* ===============================
         | 1. STATUS IS THE ONLY TRUTH
         =============================== */
        if ($applicant->status === 'hired') {
            return back()->with('error', 'This applicant has already been hired.');
        }

        if ($applicant->status !== 'shortlisted') {
            return back()->with('error', 'Only shortlisted applicants can be hired.');
        }

        DB::transaction(function () use ($applicant) {

            /* ===============================
             | 2. CHECK USER BY EMAIL ONLY
             =============================== */
            $user = User::where('email', $applicant->email)->first();

            $plainPassword = null;

            if (!$user) {
                $plainPassword = Str::random(10);

                $user = User::create([
                    'name'                 => $applicant->full_name,
                    'email'                => $applicant->email,
                    'password'             => Hash::make($plainPassword),
                    'user_type'            => 'employee',
                    'must_change_password' => true,
                ]);
            }

            /* ===============================
             | 3. CREATE / UPDATE EMPLOYEE RECORD
             =============================== */
            HrEmployee::updateOrCreate(
                ['applicant_id' => $applicant->id],
                [
                    'user_id'               => $user->id,
                    'position_id'           => $applicant->vacancy->position_id,
                    'employee_code'         => 'EMP-' . strtoupper(Str::random(6)),
                    'employment_start_date' => now(),
                    'contract_type'         => $applicant->vacancy->position->employment_type,
                    'status'                => 'active',
                ]
            );

            /* ===============================
             | 4. UPDATE APPLICANT STATUS
             =============================== */
            $applicant->update(['status' => 'hired']);

            /* ===============================
             | 5. EMAIL ONLY FOR NEW USER
             =============================== */
            if ($plainPassword) {
                Mail::send(
                    'emails.hr.employee-welcome',
                    [
                        'name'     => $user->name,
                        'email'    => $user->email,
                        'password' => $plainPassword,
                        'userType' => 'Employee',
                    ],
                    function ($message) use ($user) {
                        $message->to($user->email)
                                ->subject('🎉 Congratulations! You Have Been Hired');
                    }
                );
            }
        });

        return back()->with('success', 'Applicant hired successfully.');

    } catch (\Throwable $e) {
        return back()->with('error', $e->getMessage());
    }
}






    public function scheduleInterview(Request $request, HrApplicant $applicant)
{
    $request->validate([
        'interview_date' => 'required|date',
        'interview_mode' => 'required|in:physical,virtual',
        'interview_link' => 'nullable|string|max:255',
    ]);

    DB::table('hr_interviews')->insert([
        'applicant_id'   => $applicant->id,
        'interview_date' => $request->interview_date,
        'interview_mode' => $request->interview_mode,
        'interview_link' => $request->interview_link,
        'scheduled_by'   => Auth::id(),
        'created_at'     => now(),
    ]);

    $applicant->update(['status' => 'interviewed']);

    return back()->with('success', 'Interview scheduled.');
}


public function bulkScoreApplicants(HrVacancy $vacancy)
{
    $applicants = HrApplicant::where('vacancy_id', $vacancy->id)
        ->where('status', 'applied')
        ->get();

    foreach ($applicants as $applicant) {
        $score = $this->aiScoreApplicant($applicant);

        DB::table('hr_shortlists')->insert([
            'applicant_id'   => $applicant->id,
            'stage'          => 'screening',
            'score'          => $score,
            'remarks'        => 'Bulk AI scoring',
            'shortlisted_by' => Auth::id(),
            'shortlisted_at' => now(),
        ]);

        $applicant->update(['status' => 'scored']);
    }

    return back()->with('success', 'All applicants scored successfully.');
}


public function analytics()
{
    return view('hr.analytics.index', [
        'totalApplicants' => HrApplicant::count(),
        'scored' => HrApplicant::where('status','scored')->count(),
        'shortlisted' => HrApplicant::where('status','shortlisted')->count(),
        'hired' => HrApplicant::where('status','hired')->count(),
        'rejected' => HrApplicant::where('status','rejected')->count(),
    ]);
}

}