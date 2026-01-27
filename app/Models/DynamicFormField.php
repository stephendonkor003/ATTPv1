<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicFormField extends Model
{
    protected $table = 'dynamic_form_fields';

    protected $fillable = [
        'form_id',
        'label',
        'field_key',
        'field_type',
        'is_required',
        'options',
        'sort_order',
        'created_by',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    /**
     * Parent Form
     */
    public function form()
    {
        return $this->belongsTo(DynamicForm::class, 'form_id');
    }
}