<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'role',
    ];

    // 🔗 Relationships
    public function team()
    {
        return $this->belongsTo(EvaluatorTeam::class, 'team_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}