<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SortieObservateurs extends Model
{
    protected $fillable = [

        'role',
        'sortie_id',
        'user_id',
    ];

    public function sortie()
    {
        return $this->belongsTo(Sortie::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
 
}
