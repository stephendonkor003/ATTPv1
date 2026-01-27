<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeoRegion extends Model
{
    protected $fillable = ['continent', 'sub_region', 'country', 'region_group'];
}