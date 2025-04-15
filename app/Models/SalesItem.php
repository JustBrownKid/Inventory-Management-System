<?php

namespace App\Models;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    // id, sale_id (FK), product_id (FK), quantity, unit_price, timestamps
    protected $fillable =[
        'sale_id', 'product_id', 'quantity', 'unit_price'
    ];
    public function  saleas()
    {
        return $this->belongsTo(Sale::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
