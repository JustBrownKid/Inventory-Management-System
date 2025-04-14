<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaesItem extends Model
{
    protected $table = 'purchase_items';


    protected $fillable = ['purchase_id', 'product_id', 'quantity', 'unit_price'];

    public function items()
{
    return $this->hasMany(PurchaesItem::class, 'purchase_id');
}

}
