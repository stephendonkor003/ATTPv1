<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluationCriteriaScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'evaluation_criteria_id',
        'score',
        'decision',
        'comment',
    ];


     protected $casts = [
        'decision' => 'integer',
        'score'    => 'float',
    ];


    public function submission()
    {
        return $this->belongsTo(EvaluationSubmission::class);
    }

    public function criteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'evaluation_criteria_id');
    }
}