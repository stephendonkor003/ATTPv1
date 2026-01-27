<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementFormAssignment extends Model
{
    protected $fillable = [
        'procurement_id',
        'form_id',
        'stage',
        'created_by',
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