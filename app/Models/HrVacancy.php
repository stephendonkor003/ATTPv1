<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrVacancy extends Model
{
    protected $table = 'hr_vacancies';

    protected $fillable = [
        'position_id',
        'vacancy_code',
        'open_date',
        'close_date',
        'number_of_positions',
        'is_public',
        'status',
        'approved_by',
        'approved_at',
        'created_by',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'open_date' => 'date',
        'close_date' => 'date',
    ];

    public function position()
    {
        return $this->belongsTo(HrPosition::class, 'position_id');
    }

    public function applicants()
    {
        return $this->hasMany(HrApplicant::class, 'vacancy_id');
    }



}