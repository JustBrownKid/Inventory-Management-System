@extends('layouts.master')

@section('title', 'Edit Purchase')

@section('content')
<div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Purchase</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <div>
        <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
        <select name="supplier_id" id="supplier_id" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}" 
                    {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="purchase_date" class="block text-sm font-medium text-gray-700">Purchase Date</label>
        <input type="date" name="purchase_date" id="purchase_date" value="{{ $purchase->purchase_date }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
    </div>

    <div>
        <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
        <textarea name="note" id="note" rows="4" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ $purchase->note }}</textarea>
    </div>

    <div id="items">
        <label class="block text-sm font-medium text-gray-700">Items</label>
        @foreach($purchase->items as $index => $item)
            <div class="item space-y-4 border-b border-gray-200 pb-4 mb-4" data-index="{{ $index }}">
                <div class="flex space-x-4">
                    <div class="w-full">
                        <label for="product_id" class="block text-sm font-medium text-gray-700">Product</label>
                        <select name="items[{{ $index }}][product_id]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                    {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-1/4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <div class="flex items-center space-x-2">
                            <button type="button" class="decrease-quantity text-red-500 hover:text-red-700 font-semibold">-</button>
                            <input type="number" name="items[{{ $index }}][quantity]" value="{{ old('items.' . $index . '.quantity', $item->quantity) }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 quantity-input">

                            <button type="button" class="increase-quantity text-green-500 hover:text-green-700 font-semibold">+</button>
                        </div>
                    </div>

                    <div class="w-1/4">
                        <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price</label>
                        <input type="number" name="items[{{ $index }}][unit_price]" value="{{ old('items.' . $index . '.unit_price', $item->unit_price) }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="flex items-center space-x-2">
                        <button type="button" class="remove-item text-red-500 hover:text-red-700 font-semibold">Remove</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-start">
        <button type="button" id="addItemBtn" class="px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-md">Add Item</button>
    </div>

    <div class="flex justify-end">
        <button type="submit" class="px-6 py-3 text-white bg-green-600 hover:bg-green-700 rounded-md shadow-md">Update Purchase</button>
    </div>
</form>

<script>
  
    document.getElementById('addItemBtn').addEventListener('click', function() {
        const itemsDiv = document.getElementById('items');
        const itemCount = itemsDiv.children.length;
        const newItemDiv = document.createElement('div');
        newItemDiv.classList.add('item', 'space-y-4', 'border-b', 'border-gray-200', 'pb-4', 'mb-4');
        
        newItemDiv.innerHTML = `
            <div class="flex space-x-4">
                <div class="w-full">
                    <label for="product_id" class="block text-sm font-medium text-gray-700">Product</label>
                    <select name="items[${itemCount}][product_id]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-1/4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <div class="flex items-center space-x-2">
                        <!-- Decrease Button -->
                        <button type="button" class="decrease-quantity text-red-500 hover:text-red-700 font-semibold">-</button>
                        <input type="number" name="items[${itemCount}][quantity]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 quantity-input">
                        <!-- Increase Button -->
                        <button type="button" class="increase-quantity text-green-500 hover:text-green-700 font-semibold">+</button>
                    </div>
                </div>

                <div class="w-1/4">
                    <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price</label>
                    <input type="number" name="items[${itemCount}][unit_price]" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="flex items-center space-x-2">
                    <!-- Remove Item Button -->
                    <button type="button" class="remove-item text-red-500 hover:text-red-700 font-semibold">Remove</button>
                </div>
            </div>
        `;
        
        itemsDiv.appendChild(newItemDiv);
    });

    document.getElementById('items').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-item')) {
            const itemDiv = event.target.closest('.item');
            itemDiv.remove();
        }
    });

   
    document.getElementById('items').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('decrease-quantity')) {
            const quantityInput = event.target.closest('.flex').querySelector('.quantity-input');
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }
    });

    document.getElementById('items').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('increase-quantity')) {
            const quantityInput = event.target.closest('.flex').querySelector('.quantity-input');
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        }
    });
</script>


@endsection
