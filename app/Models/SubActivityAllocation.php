<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubActivityAllocation extends Model
{
    protected $table = 'myb_sub_activity_allocations';

    protected $fillable = [
        'sub_activity_id',
        'year',
        'amount',
    ];

    public function subActivity()
    {
        return $this->belongsTo(SubActivity::class, 'sub_activity_id');
    }
}
