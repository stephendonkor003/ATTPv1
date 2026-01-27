<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisitMedia extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'site_visit_id',
        'observation_id',
        'file_path',
        'file_type',
        'uploaded_by',
    ];

    public function siteVisit()
    {
        return $this->belongsTo(SiteVisit::class);
    }

    public function observation()
    {
        return $this->belongsTo(SiteVisitObservation::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}