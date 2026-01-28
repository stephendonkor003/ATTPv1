<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// ✅ ADD THESE
use App\Models\Role;
use App\Models\Permission;
use App\Models\GovernanceNode;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'must_change_password',
        'role_id',
        'governance_node_id',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'     => 'datetime',
            'password'              => 'hashed',
            'must_change_password'  => 'boolean',
        ];
    }

    /* =====================================================
     | EXISTING RELATIONSHIPS (UNCHANGED)
     ===================================================== */

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function committeeMemberships()
    {
        return $this->hasMany(CommitteeMember::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'evaluator_id');
    }

    public function assignedApplicants()
    {
        return $this->belongsToMany(Applicant::class, 'applicant_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function evaluatorTeamsLed()
    {
        return $this->hasMany(EvaluatorTeam::class, 'leader_id');
    }

    public function teamMemberships()
    {
        return $this->hasMany(TeamMember::class, 'user_id');
    }

    /* =====================================================
     | ROLE & PERMISSIONS
     ===================================================== */

    /**
     * User belongs to a role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function governanceNode()
    {
        return $this->belongsTo(GovernanceNode::class, 'governance_node_id');
    }

    /**
     * Direct permissions (override layer)
     */
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'user_permission'
        );
    }

    /**
     * FINAL permission check (ROLE + DIRECT)
     */
    public function hasPermission(string $permission): bool
    {
        // 1️⃣ Direct user permission override
        if ($this->permissions->contains('name', $permission)) {
            return true;
        }

        // 2️⃣ Role-based permission
        return $this->role
            && $this->role->permissions->contains('name', $permission);
    }

    /* =====================================================
     | CONVENIENCE HELPERS
     ===================================================== */

    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'System Admin';
    }

    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }
}
