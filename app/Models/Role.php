<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /* ===============================
     | RELATIONSHIPS
     =============================== */

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permission'
        );
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /* ===============================
     | HELPERS
     =============================== */

    public function hasPermission(string $permission): bool
    {
        return $this->permissions->contains('name', $permission);
    }
}