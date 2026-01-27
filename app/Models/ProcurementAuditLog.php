<?php

// App\Models\ProcurementAuditLog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementAuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'procurement_id',
        'form_id',
        'submission_id',
        'metadata',
        'created_at'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];
}