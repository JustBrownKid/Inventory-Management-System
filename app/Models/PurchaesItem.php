<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Purchaes;
use Illuminate\Database\Eloquent\Model;

class PurchaesItem extends Model
{
    //
    protected $fillable = [
        'purchase_id', 'product_id', 'quantity', 'unit_price'
    ];
    public function puschaes()
    {
        return $this->belongsTo(Purchaes::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
