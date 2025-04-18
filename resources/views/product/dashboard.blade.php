
@extends('layouts.master')

@section('title', 'Product Create') 

@section('content')

@if (session('success'))
    <div id="toast" class="fixed top-5 right-5 p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg shadow-lg transform transition-all opacity-100">
        <span class="font-medium">Success!</span> {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.classList.add('opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 500); 
            }
        }, 5000); 
    </script>
@endif
<div class="w-full bg-slate-500 p-3 text-white text-center ">
    <h1 class="text-2xl font-bold tracking-wide">Creat Product Selection</h1>
</div>

<div class="container mx-auto p-6">
<form action="{{ route('products.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block font-semibold text-gray-700">Product Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block font-semibold text-gray-700">SKU</label>
        <input type="text" name="sku" value="{{ old('sku') }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('sku')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block font-semibold text-gray-700">Category</label>
        <select name="category_id" class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="">Select</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block font-semibold  text-gray-700">Price</label>
        <input type="text" name="price" value="{{ old('price') }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('price')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block font-semibold text-gray-700">Quantity</label>
        <input type="text" name="quantity" value="{{ old('quantity') }}" class="w-full border border-gray-300 rounded px-3 py-2">
        @error('quantity')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block font-semibold text-gray-700">Description</label>
        <textarea name="description" required class="w-full border border-gray-300 rounded px-3 py-2" rows="4">{{ old('description') }}</textarea>
        @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Product
        </button>
    </div>
</form>
</div>
@endsection
