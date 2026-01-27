<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'myb_sectors';

    protected $fillable = [
        'name',
        'description',
    ];

    public function programs()
    {
        return $this->hasMany(Program::class, 'sector_id');
    }
}
