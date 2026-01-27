<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisitAssignment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'site_visit_id',
        'user_id',
    ];

    public function siteVisit()
    {
        return $this->belongsTo(SiteVisit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}