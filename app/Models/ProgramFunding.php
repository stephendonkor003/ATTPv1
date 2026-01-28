<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GovernanceNode;
use App\Models\User;

class ProgramFunding extends Model
{
    protected $table = 'myb_program_fundings';

    protected $fillable = [
        'department_id',
        'program_id',
        'program_name',
        'funder_id',
        'governance_node_id',
        'funding_type',
        'approved_amount',
        'currency',
        'start_year',
        'end_year',
        'status',
        'rejection_reason',
        'rejected_by',
        'rejected_at',
        'approved_by',
        'approved_at',
        'created_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'approved_amount' => 'decimal:2',
    ];

    /* ==========================
     * RELATIONSHIPS
     * ========================== */

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function funder()
    {
        return $this->belongsTo(Funder::class, 'funder_id');
    }

    public function governanceNode()
    {
        return $this->belongsTo(GovernanceNode::class, 'governance_node_id');
    }




    public function documents()
    {
        return $this->hasMany(
            ProgramFundingDocument::class,
            'program_funding_id'
        );
    }


    /* ==========================
     * STATUS HELPERS
     * ========================== */

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isExpired(): bool
    {
        return now()->year > $this->end_year;
    }

    /* ==========================
     * YEAR HELPERS
     * ========================== */

    public function years(): array
    {
        return range($this->start_year, $this->end_year);
    }

    public function commitments()
{
    return $this->hasMany(BudgetCommitment::class, 'program_funding_id');
}


public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

}
