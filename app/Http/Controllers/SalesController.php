<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    //
    public function list()
    {
        $sales = Sale::with('customer')->paginate(10); 
        return view('sales.list', compact('sales'));  // Make sure 'sale.list' view exists
    }

    // Show create sale form
    public function index()
    {
        return view('sales.create', [
            'customers' => Customer::all(),
            'products' => Product::all(),
        ]);
    }

    // Store a new sale
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sale_date' => 'required|date',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $totalAmount = collect($validated['items'])->sum(function ($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        $sale = Sale::create([
            'customer_id' => $validated['customer_id'],
            'sale_date' => $validated['sale_date'],
            'note' => $validated['note'],
            'total_amount' => $totalAmount,
        ]);

        foreach ($validated['items'] as $item) {
            $sale->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'sale_id' => $sale->id,
            ]);

            $product = Product::find($item['product_id']);
            $product->decrement('quantity', $item['quantity']);
        }

        return redirect()->route('sales')->with('success', 'Sale recorded successfully!');
    }

    // Show edit form for a sal
    public function edit($id)
{
    $sale = Sale::with('items.product')->findOrFail($id); // Make sure to load the sale with items and products
    $customers = Customer::all(); // Retrieve all customers
    $products = Product::all();   // Retrieve all products

    return view('sales.edit', compact('sale', 'customers', 'products'));
}


    // Update a sale
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sale_date' => 'required|date',
            'note' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $sale = Sale::findOrFail($id);

        $totalAmount = collect($validated['items'])->sum(function ($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        $sale->update([
            'customer_id' => $validated['customer_id'],
            'sale_date' => $validated['sale_date'],
            'note' => $validated['note'],
            'total_amount' => $totalAmount,
        ]);

        foreach ($validated['items'] as $item) {
            $existingItem = $sale->items()->where('product_id', $item['product_id'])->first();

            if ($existingItem) {
                $quantityDifference = $item['quantity'] - $existingItem->quantity;

                $existingItem->update([
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);

                $product = Product::find($item['product_id']);
                $product->decrement('quantity', $quantityDifference);
            } else {
                $sale->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'sale_id' => $sale->id,
                ]);

                $product = Product::find($item['product_id']);
                $product->decrement('quantity', $item['quantity']);
            }
        }

        return redirect()->route('sales')->with('success', 'Sale updated successfully!');
    }
}
