<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = [ 
        //  zone table
        'name',
        'nbre_points',
    ];

    public function pointDePassages()
    {   
        return $this->hasMany(PointDePassage::class, 'zone_id');
    }
 
}
