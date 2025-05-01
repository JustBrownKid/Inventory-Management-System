@extends('layouts.master')

@section('title', 'Product Create')

@section('content')

@if (session('success'))
    <div id="toast" class="p-3 bg-green-200 text-green-800 rounded shadow">
        <strong>Success:</strong> {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            }
        }, 5000);
    </script>
@endif

<h2 class="text-xl font-semibold text-center my-4">Create Product</h2>

<div class="px-24 card m-5 mx-auto">
    <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label>Product Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>SKU</label>
            <input type="text" name="sku" value="{{ old('sku') }}" class="w-full border p-2">
            @error('sku')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Category</label>
            <select name="category_id" class="w-full border p-2">
                <option value="">Select</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Price</label>
            <input type="text" name="price" value="{{ old('price') }}" class="w-full border p-2">
            @error('price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Quantity</label>
            <input type="text" name="quantity" value="{{ old('quantity') }}" class="w-full border p-2">
            @error('quantity')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Description</label>
            <textarea name="description" class="w-full border p-2" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
        </div>
    </form>
</div>
@endsection
