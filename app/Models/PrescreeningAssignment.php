<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescreeningAssignment extends Model
{
    protected $fillable = [
        'procurement_id',
        'user_id',
        'assigned_by',
        'assigned_at',
    ];

    public $timestamps = false;

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}