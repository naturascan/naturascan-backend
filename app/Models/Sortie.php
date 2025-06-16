<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sortie extends Model
{
    protected $fillable = [
        'type',
        'finished',
        'synchronised',
        'user_id',
    ];

    public function obstrace()
    {
        return $this->hasOne(SortieObstrace::class);
    }

    public function naturascan()
    {
        return $this->hasOne(SortieNaturascan::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
