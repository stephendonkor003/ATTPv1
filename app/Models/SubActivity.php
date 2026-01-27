<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubActivity extends Model
{
    protected $table = 'myb_sub_activities';

    protected $fillable = [
        'activity_id',
        'name',
        'description',
        'created_by',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function allocations()
    {
        return $this->hasMany(SubActivityAllocation::class, 'sub_activity_id');
    }




    public function years()
    {
        return $this->activity->years();
    }

    public function totalAllocation()
    {
        return $this->allocations->sum('amount');
    }

    public function yearlyTotals()
{
    $years = $this->years();
    $totals = [];

    foreach ($years as $year) {
        $totals[$year] = $this->allocations->where('year', $year)->sum('amount');
    }

    return $totals;
}

}
