<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisitObservation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'site_visit_id',
        'category',
        'description',
        'severity',
        'action_required',
    ];

    protected $casts = [
        'action_required' => 'boolean',
    ];

    public function siteVisit()
    {
        return $this->belongsTo(SiteVisit::class);
    }

    public function media()
    {
        return $this->hasMany(SiteVisitMedia::class, 'observation_id');
    }
}