<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'address',
        'photo',
    ];


     public function orders()
    {
        return $this->hasMany(Order::class);
    }

    
}
