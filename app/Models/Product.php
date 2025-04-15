<?php

namespace App\Models;

use App\Models\Categorie;
use App\Models\SalesItem;
use App\Models\PurchaesItem;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'sku' , 'category_id', 'price', 'quantity', 'description'
    ];
    public function categories()
    {
        return $this->belongTo(Categorie::class);
    }
    public function salesItems()
    {
        return $this->hasMany(SalesItem::class);
    }
    public function purchaesItems()
    {
        return $this->belongsToMany(PurchaesItem::class);
    }
}
