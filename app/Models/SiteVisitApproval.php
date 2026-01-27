<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisitApproval extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'site_visit_id',
        'reviewer_id',
        'status',
        'remarks',
    ];

    public function siteVisit()
    {
        return $this->belongsTo(SiteVisit::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}