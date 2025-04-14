<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $table = 'purchase_items';


    protected $fillable = ['purchase_id', 'product_id', 'quantity', 'unit_price'];

    public function items()
{
    return $this->hasMany(PurchaseItem::class, 'purchase_id');
}

}
