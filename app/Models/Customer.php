<?php

namespace App\Models;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //id, name, phone, email, address, timestamps

    protected $fillable = [
        'name', 'phone' , 'email', 'address'
    ];
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
