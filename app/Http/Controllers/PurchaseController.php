<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
   
    public function list()
    {
       
        $purchases = Purchase::with('supplier')->paginate(10); 
    
        return view('purchase.list', compact('purchases'));
    }
    

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

        $purchase = Purchase::create([
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
    
    public function edit($id)
    {
        $purchase = Purchase::with('items')->findOrFail($id);

        return view('purchase.edit', [
            'purchase' => $purchase,
            'suppliers' => Supplier::all(),
            'products' => Product::all(),
        ]);
    }
    
    public function update(Request $request, $id)
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

    $purchase = Purchase::findOrFail($id);

    $totalAmount = collect($validated['items'])->sum(function ($item) {
        return $item['quantity'] * $item['unit_price'];
    });

    $purchase->update([
        'supplier_id' => $validated['supplier_id'],
        'purchase_date' => $validated['purchase_date'],
        'note' => $validated['note'],
        'total_amount' => $totalAmount,
    ]);

  
    foreach ($validated['items'] as $index => $item) {
      
        $existingItem = $purchase->items()->where('product_id', $item['product_id'])->first();

        if ($existingItem) {
            
            $quantityDifference = $item['quantity'] - $existingItem->quantity;

            $existingItem->update([
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);

                     $product = Product::find($item['product_id']);
            $product->increment('quantity', $quantityDifference); 
        } else {
          
            $purchase->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'purchase_id' => $purchase->id,
            ]);

            $product = Product::find($item['product_id']);
            $product->increment('quantity', $item['quantity']);
        }
    }

    return redirect()->route('purchases')->with('success', 'Purchase updated successfully!');
}


}

