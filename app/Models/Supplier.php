<?php

namespace App\Models;

use App\Models\Purchaes;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //name, phone, email, address,
    protected $fillable = [
        'name', 'phone' , 'email', 'address'
    ];

    public function purcheses()
    {
        return $this->hasMany(Purchaes::class);
    }
}
