
@extends('layouts.master')

@section('title', 'Welcome to My Application') 

@section('content')


@if (session('success'))
    <div id="toast" class="fixed top-5 right-5 p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg shadow-lg transform transition-all opacity-100">
        <span class="font-medium">Success!</span> {{ session('success') }}
    </div>
@endif


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
        <label class="block font-semibold text-gray-700">Price</label>
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
        <textarea name="description" class="w-full border border-gray-300 rounded px-3 py-2" rows="4">{{ old('description') }}</textarea>
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


<script>
    if (document.getElementById('toast')) {
        setTimeout(function() {
            // Add classes to fade out and move the toast up
            document.getElementById('toast').classList.replace('opacity-100', 'opacity-0');
            document.getElementById('toast').classList.replace('top-5', '-top-20'); // Move it above the screen for hiding
            setTimeout(function() {
                document.getElementById('toast').style.display = 'none'; // Hide the toast completely
            }, 500); // Delay of the fade-out animation
        }, 5000); // 5000 milliseconds = 5 seconds
    }
</script>
@endsection
