<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funder extends Model
{
    protected $table = 'myb_funders';

    protected $fillable = [
        'name',
        'type',
        'currency',
    ];

    /* ==========================
     * RELATIONSHIPS
     * ========================== */

    public function programFundings()
    {
        return $this->hasMany(ProgramFunding::class, 'funder_id');
    }
}