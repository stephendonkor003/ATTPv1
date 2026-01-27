<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescreeningTemplateProcurement extends Model
{
    protected $fillable = [
        'procurement_id',
        'prescreening_template_id',
        'assigned_by',
        'assigned_at',
    ];

    public $timestamps = false;

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }

    public function template()
    {
        return $this->belongsTo(PrescreeningTemplate::class, 'prescreening_template_id');
    }
}