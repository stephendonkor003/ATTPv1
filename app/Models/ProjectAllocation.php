<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAllocation extends Model
{
    protected $table = 'myb_project_allocations';

       protected $fillable = [
        'project_id',
        'year',          // REQUIRED COLUMN
        'year_number',   // 1,2,3...
        'actual_year',   // calendar year (e.g., 2025)
        'amount',
    ];

    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}