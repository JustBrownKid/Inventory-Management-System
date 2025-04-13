
@extends('layouts.master')

@section('title', 'Welcome to My Application') 


@section('content')


<form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block font-semibold text-gray-700">Product Name</label>
        <input type="text" name="name" value="{{ $product->name }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block font-semibold text-gray-700">SKU</label>
        <input type="text" name="sku" value="{{  $product->sku }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('sku')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
    <label class="block font-semibold text-gray-700">Category</label>
<select name="category_id" class="w-full border border-gray-300 rounded px-3 py-2">
    <option value="">Select</option>
    @foreach($categories as $category)
        <option value="{{ $category->id }}" 
            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
    @endforeach
</select>
        @error('category_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    <div>
        <label class="block font-semibold text-gray-700">Price</label>
        <input type="text" name="price" value="{{ $product->price }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('price')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block font-semibold text-gray-700">Quantity</label>
        <input type="text" name="quantity" value="{{ $product->quantity }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('quantity')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block font-semibold text-gray-700">Description</label>
        <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2" rows="4">{{ $product->description }}</textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <button type="submit" class="bg-blue-600 mt- text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Product
        </button>
    </div>
</form>

@endsection
