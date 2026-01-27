<?php

namespace App\Http\Controllers;

use App\Models\ProgramFunding;
use App\Models\ProgramFundingDocument;
use App\Models\Department;
use App\Models\Program;
use App\Models\Funder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProgramFundingController extends Controller
{
    /* =====================================================
     * INDEX – GOVERNANCE + ANALYTICS
     * ===================================================== */
    public function index()
{
    $fundings = ProgramFunding::with([
            'program',
            'funder',
        ])
        ->latest()
        ->paginate(15);

    return view('finance.program-funding.index', compact('fundings'));
}



    /* =====================================================
     * CREATE
     * ===================================================== */
    public function create()
    {
        return view('finance.program-funding.create', [
            'departments' => Department::where('status', 'active')->orderBy('name')->get(),
            'programs'    => Program::orderBy('name')->get(),
            'funders'     => Funder::orderBy('name')->get(),
        ]);
    }




 public function store(Request $request)
{
    DB::beginTransaction();

    try {

        /* ================= VALIDATION ================= */
        $validated = $request->validate([
            'department_id'   => 'required|exists:myb_departments,id',
            'program_id'      => 'required|exists:myb_programs,id',
            'funder_id'       => 'required|exists:myb_funders,id',
            'funding_type'    => 'required|in:grant,allocation,capital',
            'approved_amount' => 'required|numeric|min:0',
            'currency'        => 'required|string|max:10',
            'start_year'      => 'required|integer|min:2000',
            'end_year'        => 'required|integer|gte:start_year',

            // Documents
            'documents'        => 'nullable|array',
            'documents.*'      => 'file|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:5120',
            'document_types'   => 'required_with:documents|array',
            'document_types.*' => 'required|string|max:100',
            'document_names'   => 'required_with:documents|array',
            'document_names.*' => 'required|string|max:255',
        ]);

        /* ================= PROGRAM RULES ================= */
        $program = Program::findOrFail($validated['program_id']);

        if (
            $validated['start_year'] < $program->start_year ||
            $validated['end_year'] > $program->end_year
        ) {
            throw new \Exception(
                "Funding period must fall within Program years ({$program->start_year} – {$program->end_year})."
            );
        }

        if ($validated['currency'] !== $program->currency) {
            throw new \Exception(
                "Funding currency must match Program currency ({$program->currency})."
            );
        }

        /* ================= CREATE FUNDING ================= */
        $funding = ProgramFunding::create([
            'department_id'   => $validated['department_id'],
            'program_id'      => $validated['program_id'],
            'funder_id'       => $validated['funder_id'],
            'funding_type'    => $validated['funding_type'],
            'approved_amount' => $validated['approved_amount'],
            'currency'        => $validated['currency'],
            'start_year'      => $validated['start_year'],
            'end_year'        => $validated['end_year'],
            'status'          => 'draft',
            'created_by'      => Auth::id(),
        ]);

        /* ================= SAVE DOCUMENTS ================= */
        if ($request->hasFile('documents')) {

            $files = $request->file('documents');
            $types = $request->input('document_types');
            $names = $request->input('document_names');

            foreach ($files as $index => $file) {

                if (!$file->isValid()) {
                    throw new \Exception('Invalid document upload detected.');
                }

                if (!isset($types[$index])) {
                    throw new \Exception('Document type mismatch detected.');
                }

                // Safe fallback for name
                $fileName = $names[$index]
                    ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                $storedPath = $file->store(
                    'program-funding-documents',
                    'public'
                );

                ProgramFundingDocument::create([
                    'program_funding_id' => $funding->id,
                    'document_type'      => $types[$index],
                    'file_name'          => $fileName, // ✅ FIXED
                    'file_path'          => $storedPath,
                    'uploaded_by'        => Auth::id(),
                ]);
            }
        }

        DB::commit();

        return redirect()
            ->route('finance.program-funding.index')
            ->with('success', 'Program funding created successfully with documents.');

    } catch (\Throwable $e) {

        DB::rollBack();

        Log::error('Program Funding Store Error', [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ]);

        return back()
            ->withErrors(['error' => $e->getMessage()])
            ->withInput();
    }
}



    /* =====================================================
     * SHOW
     * ===================================================== */
 public function show($id)
{
    $programFunding = ProgramFunding::with([
        'department',
        'program',
        'funder',
        'documents',
        'creator',
    ])->findOrFail($id);

    /*
     |-----------------------------------------------------------
     | CRITICAL DATA INTEGRITY CHECKS
     |-----------------------------------------------------------
     | If any of these are missing, it means the record
     | is incomplete or corrupted.
     */
    if (
        !$programFunding->department ||
        !$programFunding->program ||
        !$programFunding->funder
    ) {
        abort(
            422,
            'Program funding record is incomplete. Department, Program, or Funder is missing.'
        );
    }

    return view('finance.program-funding.show', compact('programFunding'));
}


    /* =====================================================
     * SUBMIT / APPROVE / REJECT
     * ===================================================== */
    // public function submit(ProgramFunding $programFunding)
    // {
    //     abort_if($programFunding->status !== 'draft', 403);

    //     $programFunding->update([
    //         'status'       => 'submitted',
    //         'submitted_at' => now(),
    //     ]);

    //     return back()->with('success', 'Funding submitted for approval.');
    // }


    public function submit(ProgramFunding $funding)
    {
        abort_if($funding->status !== 'draft', 403);

        $funding->update([
            'status'       => 'submitted',
            'submitted_at' => now(),
        ]);

        return back()->with('success', 'Funding submitted for approval.');
    }


    public function approve(ProgramFunding $funding)
    {
        abort_if($funding->status !== 'submitted', 403);

        $allocated = $funding->program
            ? $funding->program->totalAllocatedAmount()
            : 0;

        if ($allocated > $funding->approved_amount) {
            return back()->withErrors([
                'approved_amount' =>
                    'Cannot approve funding. Allocations already exceed approved amount.',
            ]);
        }

        $funding->update([
            'status'      => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Funding approved.');
    }

    public function reject(ProgramFunding $funding)
    {
        abort_if($funding->status !== 'submitted', 403);

        $funding->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Funding rejected.');
    }



    /* =====================================================
 * EDIT
 * ===================================================== */
public function edit(ProgramFunding $programFunding)
{
    abort_if($programFunding->status !== 'draft', 403);

    return view('finance.program-funding.edit', compact('programFunding'));
}

/* =====================================================
 * UPDATE
 * ===================================================== */
public function update(Request $request, ProgramFunding $programFunding)
{
    abort_if($programFunding->status !== 'draft', 403);

    $validated = $request->validate([
        'approved_amount' => 'required|numeric|min:0',
        'currency'        => 'required|string|max:10',
        'start_year'      => 'required|integer|min:2000',
        'end_year'        => 'required|integer|gte:start_year',
    ]);

    $programFunding->update($validated);

    return redirect()
        ->route('finance.program-funding.show', $programFunding)
        ->with('success', 'Program funding updated successfully.');
}



}