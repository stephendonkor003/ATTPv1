<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisitGroup extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'site_visit_id',
        'group_name',
        'leader_id',
    ];

    public function siteVisit()
    {
        return $this->belongsTo(SiteVisit::class);
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function members()
    {
        return $this->hasMany(SiteVisitGroupMember::class, 'group_id');
    }
}