<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramFundingDocument extends Model
{
    protected $table = 'myb_program_funding_documents';

     protected $fillable = [
        'program_funding_id',
        'document_type',
        'file_name',      // ✅ ADD THIS
        'file_path',
        'uploaded_by',
    ];

    protected $casts = [
        'issued_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function programFunding()
    {
        return $this->belongsTo(ProgramFunding::class, 'program_funding_id');
    }
}
