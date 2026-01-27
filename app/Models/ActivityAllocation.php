<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 class ActivityAllocation extends Model
{
    protected $table = 'myb_activity_allocations';

    protected $fillable = [
        'activity_id',
        'year',
        'amount',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}