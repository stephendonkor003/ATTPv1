<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrEmployee extends Model
{
    protected $table = 'hr_employees';

    protected $fillable = [
        'applicant_id',
        'position_id',
        'employee_code',
        'employment_start_date',
        'employment_end_date',
        'contract_type',
        'salary',
        'status',
    ];

    protected $casts = [
        'employment_start_date' => 'date',
        'employment_end_date' => 'date',
    ];

    public function applicant()
    {
        return $this->belongsTo(HrApplicant::class);
    }

    public function position()
    {
        return $this->belongsTo(HrPosition::class);
    }
}
