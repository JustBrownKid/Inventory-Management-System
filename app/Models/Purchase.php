<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\PurchaseItem;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
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
        return $this->hasMany(PurchaseItem::class, 'purchase_id'); 
    }
}
