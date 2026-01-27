<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetCommitment extends Model
{
    protected $table = 'myb_budget_commitments';

    protected $fillable = [
        'program_funding_id',
        'allocation_level',
        'allocation_id',
        'resource_category_id',
        'resource_id',
        'commitment_amount',
        'commitment_year',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'commitment_amount' => 'decimal:2',
        'approved_at'       => 'datetime',
    ];

    /* =========================
        RELATIONSHIPS
    ========================== */

    public function programFunding()
    {
        return $this->belongsTo(ProgramFunding::class, 'program_funding_id');
    }

    public function resourceCategory()
    {
        return $this->belongsTo(ResourceCategory::class, 'resource_category_id');
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* =========================
        HELPERS (VERY IMPORTANT)
    ========================== */

    public function allocation()
    {
        return match ($this->allocation_level) {
            'project'      => Project::find($this->allocation_id),
            'activity'     => Activity::find($this->allocation_id),
            'sub_activity' => SubActivity::find($this->allocation_id),
            default        => null,
        };
    }
}