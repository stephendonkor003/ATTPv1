<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluationSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id',
        'name',
        'description',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function criteria()
    {
        return $this->hasMany(EvaluationCriteria::class);
    }
}