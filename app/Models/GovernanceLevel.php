<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovernanceLevel extends Model
{
    protected $table = 'myb_governance_levels';

    protected $fillable = [
        'key',
        'name',
        'sort_order',
        'description',
    ];

    public function nodes(): HasMany
    {
        return $this->hasMany(GovernanceNode::class, 'level_id');
    }
}
