<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchaes;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
   
    public function index()
    {
        return view('purchase.create', [
            'suppliers' => Supplier::all(),
            'products' => Product::all(),
        ]);
    }

  
    public function store(Request $request)
    {
      
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

      
        $totalAmount = collect($validated['items'])->sum(function ($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        $purchase = Purchaes::create([
            'supplier_id' => $validated['supplier_id'],
            'purchase_date' => $validated['purchase_date'],
            'note' => $validated['note'],
            'total_amount' => $totalAmount,
        ]);

        foreach ($validated['items'] as $item) {
            $purchase->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'purchase_id' => $purchase->id,
            ]);
        }
        $product = Product::find($item['product_id']);
        $product->increment('quantity', $item['quantity']);
      
        return redirect()->route('purchases')->with('success', 'Purchase saved successfully!');
    }
}

