<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'myb_departments';

    protected $fillable = [
        'code',
        'name',
        'description',
        'head_user_id',
        'status',
        'created_by',
    ];

    /* ==========================
     * RELATIONSHIPS
     * ========================== */

    // A Department owns many Programs
    public function programs()
    {
        return $this->hasMany(Program::class, 'department_id');
    }

    // A Department has many Program Funding records
    public function programFundings()
    {
        return $this->hasMany(ProgramFunding::class, 'department_id');
    }

    public function head()
    {
        return $this->belongsTo(\App\Models\User::class, 'head_user_id');
    }

    /* ==========================
     * HELPERS
     * ========================== */

    public function isActive(): bool
    {
        return $this->status === 'active';
    }



}