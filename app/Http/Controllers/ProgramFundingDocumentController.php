<?php

namespace App\Http\Controllers;

use App\Models\ProgramFunding;
use App\Models\ProgramFundingDocument;
use Illuminate\Http\Request;

class ProgramFundingDocumentController extends Controller
{
    public function store(Request $request, ProgramFunding $programFunding)
    {
        $data = $request->validate([
            'document_type' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx',
            'issued_date' => 'nullable|date',
            'expiry_date' => 'nullable|date',
        ]);

        $path = $request->file('file')->store('program-funding-documents');

        ProgramFundingDocument::create([
            'program_funding_id' => $programFunding->id,
            'document_type' => $data['document_type'],
            'file_path' => $path,
            'issued_date' => $data['issued_date'] ?? null,
            'expiry_date' => $data['expiry_date'] ?? null,
            'uploaded_by' => auth()->id(),
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }
}