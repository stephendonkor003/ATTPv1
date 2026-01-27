<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrApplicant extends Model
{
    protected $table = 'hr_applicants';

    public $timestamps = false;

    protected $fillable = [
        'vacancy_id',
        'full_name',
        'email',
        'phone',
        'gender',
        'nationality',
        'cv_path',
        'cover_letter_path',
        'status',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function vacancy()
    {
        return $this->belongsTo(HrVacancy::class, 'vacancy_id');
    }
}