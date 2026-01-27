<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrPosition extends Model
{
    protected $table = 'hr_positions';

    protected $fillable = [
        'resource_id',
        'department_id',
        'title',
        'employment_type',
        'grade_level',
        'description',
        'status',
        'created_by',
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function vacancies()
    {
        return $this->hasMany(HrVacancy::class, 'position_id');
    }
}
