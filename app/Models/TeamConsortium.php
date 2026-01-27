<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamConsortium extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'consortium_id',
        'assigned_by',
        'status',
    ];

    // 🔗 Relationships
    public function team()
    {
        return $this->belongsTo(EvaluatorTeam::class, 'team_id');
    }

    public function consortium()
    {
        return $this->belongsTo(Applicant::class, 'consortium_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}