<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\SalesItem;
use Illuminate\Database\Eloquent\Model;


class Sale extends Model
{
    
    protected $fillable = [
        'customer_id', 'sale_date', 'total_amount', 'note',
    ];

    // Correct the method name to `customer()` for belongsTo relationship
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationship with SalesItem (each sale has many sales items)
    public function items()
    {
        return $this->hasMany(SalesItem::class);
    }
}
