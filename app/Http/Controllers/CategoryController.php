<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:255',
    ]);

    Categorie::create($validated);
    return redirect()->back()->with('success', 'Category created successfully');
}


    public function index(){
        $categories = Categorie::orderBy('created_at', 'desc')->get();
        return view('categoryCreate', compact('categories'));
    }

    public function edit($id){
        $category = Categorie::find($id);
        return view('categoryEdit', compact('category'));
    }
    public function update(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $category = Categorie::find($id);
        $category->update($validated);

        return redirect()->route('category')->with('success', 'Category updated successfully');

    }
    public function destroy($id){
        $category = Categorie::find($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
