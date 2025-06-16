<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherReport extends Model
{
    protected $fillable = [
        'sea_state',
        'cloud_cover',
        'visibility',
        'wind_force',
        'wind_direction',
        'wind_speed',
    ];
}
