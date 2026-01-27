<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescreeningCriterion extends Model
{
    protected $table = 'prescreening_criteria';

    protected $fillable = [
        'prescreening_template_id',
        'name',
        'description',
        'field_key',
        'evaluation_type',
        'min_value',
        'is_mandatory',
        'sort_order',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
    ];

    public function template()
    {
        return $this->belongsTo(PrescreeningTemplate::class, 'prescreening_template_id');
    }
}
