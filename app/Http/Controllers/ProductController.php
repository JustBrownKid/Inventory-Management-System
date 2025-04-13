<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(){
        $categories = Categorie::all();
        return view('dashboard', compact('categories'));
    }
    
    public function store(){
        $data = request()->validate([
            'name' => 'required',
            'sku' => 'required|string',  
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'categories' => 'nullable|array',  
        ]);
        $product = Product::create([
            'name' => $data['name'],
            'sku' => $data['sku'], 
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'description' => $data['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        if (isset($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }
        return redirect()->back()->with('success', 'Product created successfully.');
    }


    public function list(){
        $products = Product::all();
        $categories = Categorie::all();
        return view('productList',compact('categories','products'));
    }


    public function edit($id){
        $product = Product::find($id);
        $categories = Categorie::all();
        $categoryName = $categories->firstWhere('id', $product->category_id)?->name;
        return view('productUpdate', compact('product', 'categoryName' ,'categories'));
    }


    public function update(Request $request, $id)
    {
       
        $data = $request->validate([
            'name' => 'required',
            'sku' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'categories' => 'nullable|array',  
        ]);
    
        $product = Product::find($id);
    
        if (!$product) {
            return redirect()->route('products.list')->with('error', 'Product not found');
        }
    
        $product->update([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'description' => $data['description'] ?? null,
            'updated_at' => now(), 
        ]);
    
        if (isset($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }
    
        return redirect()->route('products.list')->with('success', 'Product updated successfully.');
    }
    
    public function destroy($id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return redirect()->route('products.list')->with('error', 'Product not found');
        }
    
        $product->delete();
    
        return redirect()->route('products.list')->with('success', 'Product deleted successfully.');
    }

}
