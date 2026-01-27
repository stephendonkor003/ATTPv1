<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisitGroupMember extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'group_id',
        'user_id',
        'role',
    ];

    public function group()
    {
        return $this->belongsTo(SiteVisitGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}