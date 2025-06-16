<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Espece extends Model
{
    protected $fillable = [
        'common_name',
        'scientific_name',
        'description',
        'category_id',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
