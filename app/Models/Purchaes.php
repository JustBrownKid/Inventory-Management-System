<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\PurchaesItem;
use Illuminate\Database\Eloquent\Model;

class Purchaes extends Model
{
    // id, supplier_id (FK), purchase_date, total_amount, note, timestamps
    protected $fillabe = [
         'supplier_id', 'purchase_date', 'total_amount', 'note', 'timestamps'
    ];
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purchaseItems()
    {
        return $this->hasMany(PurchaesItem::class);
    }
}
