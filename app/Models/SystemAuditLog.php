<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemAuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'module',
        'action',
        'action_message',
        'description',
        'method',
        'url',
        'route_name',
        'ip_address',
        'country',
        'user_agent',
        'status_code',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
