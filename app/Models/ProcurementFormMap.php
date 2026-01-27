<?php

// App\Models\ProcurementFormMap.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementFormMap extends Model
{
    protected $fillable = [
        'procurement_id',
        'form_id',
        'stage'
    ];

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }

    public function form()
    {
        return $this->belongsTo(DynamicForm::class);
    }
}