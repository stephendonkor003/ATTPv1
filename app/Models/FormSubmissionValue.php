<?php

// App\Models\FormSubmissionValue.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmissionValue extends Model
{
    protected $fillable = [
        'submission_id',
        'field_key',
        'value'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function submission()
    {
        return $this->belongsTo(FormSubmission::class, 'submission_id');
    }
}