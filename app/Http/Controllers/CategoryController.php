<?php

namespace App\Http\Controllers;

use App\Models\Category ;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
    ]);

    Category ::create($validated);
    return redirect()->back()->with('success', 'Category created successfully');
}


    public function index(){
        $categories = Category ::orderBy('created_at', 'desc')->get();
        return view('category.categoryCreate', compact('categories'));
    }

    public function edit($id){
        $category = Category ::find($id);
        return view('category.categoryEdit', compact('category'));
    }
    public function update(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $category = Category ::find($id);
        $category->update($validated);

        return redirect()->route('category')->with('success', 'Category updated successfully');

    }
    public function destroy($id){
        $category = Category ::find($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
