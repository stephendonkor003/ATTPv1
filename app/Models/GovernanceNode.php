<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovernanceNode extends Model
{
    protected $table = 'myb_governance_nodes';

    protected $fillable = [
        'level_id',
        'name',
        'code',
        'description',
        'status',
        'effective_start',
        'created_by',
    ];

    protected $casts = [
        'effective_start' => 'date',
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(GovernanceLevel::class, 'level_id');
    }

    public function reportingLines(): HasMany
    {
        return $this->hasMany(GovernanceReportingLine::class, 'child_node_id');
    }

    public function parentLines(): HasMany
    {
        return $this->hasMany(GovernanceReportingLine::class, 'parent_node_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(GovernanceNodeAssignment::class, 'node_id');
    }
}
