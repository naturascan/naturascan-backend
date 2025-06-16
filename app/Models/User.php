<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends \TCG\Voyager\Models\User 
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'email',
        'password',
        'mobile_number',
        'adress',
        'enabled',
        'access',
        'pseudo',
    ];

    // append custom attributes
    protected $appends = ['total_export'];

    // get total export of user
    public function getTotalExportAttribute()
    {
        return $this->exports()->count();   
       
    }

    // user exports
    public function exports()
    {
        return $this->hasMany(Export::class);
    }

     
}
