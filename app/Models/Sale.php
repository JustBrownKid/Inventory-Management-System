<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\SalesItem;
use Illuminate\Database\Eloquent\Model;


class Sale extends Model
{
    
    protected $fillable = [
        'customer_id', 'sale_date', 'total_amount', 'note', 'timestamps'
    ];
    public function  customers()
    {
        return $this->belongsTo(Customer::class);
    }
    public function  salesItems()
    {
        return $this->hasMany(SalesItem::class);
    }

}
