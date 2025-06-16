<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    protected $fillable = [
        'uuid',
        'data',
        'user_id',
        'data_export'
    ];

    // get type of export
    public function the_type()
    {
       $data = json_decode($this->data,true);
        return $data['type'];
    }

    // user
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

  
}
