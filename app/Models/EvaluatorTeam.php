<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluatorTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'leader_id',
        'created_by',
    ];

    // 🔗 Relationships
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->hasMany(TeamMember::class, 'team_id');
    }

    public function consortia()
    {
        return $this->hasMany(TeamConsortium::class, 'team_id');
    }

    public function siteVisitEvaluations()
    {
        return $this->hasMany(SiteVisitEvaluation::class, 'team_id');
    }
}