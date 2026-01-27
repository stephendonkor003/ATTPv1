<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluationCriteria extends Model
{
    use HasFactory;

    /**
     * Explicit table name
     * (Laravel would otherwise look for `evaluation_criterias`)
     */
    protected $table = 'evaluation_criteria';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'evaluation_section_id',
        'name',
        'description',
        'max_score',
    ];

    /* =====================================================
     | RELATIONSHIPS
     ===================================================== */

    /**
     * Criteria belongs to a section
     */
    public function section()
    {
        return $this->belongsTo(
            EvaluationSection::class,
            'evaluation_section_id'
        );
    }

    /**
     * Shortcut: criteria → evaluation (via section)
     */
    public function evaluation()
    {
        return $this->hasOneThrough(
            Evaluation::class,
            EvaluationSection::class,
            'id',                   // FK on evaluation_sections
            'id',                   // FK on evaluations
            'evaluation_section_id', // local key on criteria
            'evaluation_id'         // local key on section
        );
    }
}