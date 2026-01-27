<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluationAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluation_id',
        'procurement_id',
        'user_id',
        'assigned_by',
        'assigned_at',
        'status',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    // App\Models\EvaluationAssignment.php



}
