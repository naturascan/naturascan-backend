<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    protected $fillable = [
        'type',
       'sortie_id' ,
       'animal_id',
       'bird_id',  
       'waste_id',
    ];

    public function sortie()
    {
        return $this->belongsTo(Sortie::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }


    public function bird()
    {
        return $this->belongsTo(Bird::class);
    }

    public function waste()
    {
        return $this->belongsTo(Waste::class);
    }

  
}
