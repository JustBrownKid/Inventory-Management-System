<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\PurchaesItem;
use Illuminate\Database\Eloquent\Model;

class Purchaes extends Model
{
    
    protected $table = 'purchases';


    protected $fillable = [
        'supplier_id', 'purchase_date', 'total_amount', 'note'
    ];

  
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);  
    }

    public function items()
    {
        return $this->hasMany(PurchaesItem::class, 'purchase_id'); 
    }
}
