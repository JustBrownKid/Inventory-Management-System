@extends('layouts.master')

@section('title', 'Create Sale')

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
                setTimeout(() => toast.remove(), 500); 
            }
        }, 5000);
    </script>
@endif

<div class="max-w-4xl mx-auto py-8 px-4">
    <h2 class="text-2xl font-semibold mb-6">Create Sale</h2>

    <form action="{{ route('sales.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Customer -->
        <div class="flex space-x-6">
    <!-- Customer -->
    <div class="w-1/2">
        <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer</label>
        <select name="customer_id" id="customer_id" class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Sale Date -->
    <div class="w-1/2">
        <label for="sale_date" class="block text-sm font-medium text-gray-700">Sale Date</label>
        <input type="date" name="sale_date" id="sale_date" value="{{ old('sale_date', now()->toDateString()) }}" class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
    </div>
</div>

        <!-- Note -->
        <div>
            <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
            <textarea name="note" id="note" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('note') }}</textarea>
        </div>

        <!-- Sale Items -->
        <div>
            <h4 class="text-lg font-medium mb-2">Sale Items</h4>
            <table class="min-w-full bg-white border border-gray-300 text-sm text-left" id="items-table">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Product</th>
                        <th class="px-4 py-2 border">Qty</th>
                        <th class="px-4 py-2 border">Unit Price</th>
                        <th class="px-4 py-2 border">Total</th>
                        <th class="px-4 py-2 border text-center">
                            <button type="button" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600" id="add-item">+</button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Items will be added here dynamically -->
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div>
            <strong class="text-lg">Total Amount: MMK<span id="grand-total">0</span></strong>
        </div>

        <!-- Submit -->
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                Save Sale
            </button>
            <a href="{{ route('sales') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">
                Cancel
            </a>
        </div>
    </form>
</div>

<template id="product-options-template">
    @foreach($products as $product)
        <option value="{{ $product->id }}">{{ $product->name }}</option>
    @endforeach
</template>

<script>
    let products = @json($products);
    let itemIndex = 0;

    function calculateLineTotal(row) {
        let qty = parseFloat(row.querySelector('.qty').value) || 0;
        let price = parseFloat(row.querySelector('.unit-price').value) || 0;
        row.querySelector('.line-total').textContent = (qty * price).toFixed(2);
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        document.querySelectorAll('.line-total').forEach(el => {
            total += parseFloat(el.textContent) || 0;
        });
        document.getElementById('grand-total').textContent = total.toFixed(2);
    }

    function addRow() {
        let tbody = document.querySelector('#items-table tbody');
        let tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="border px-4 py-2">
                <select name="items[${itemIndex}][product_id]" class="w-40 border-gray-300 rounded-md" required>
                    <option value="">Select Product</option>
                    ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
                </select>
            </td>
            <td class="border px-4 py-2">
                <input type="number" name="items[${itemIndex}][quantity]" class="w-30 h-7 border-gray-300 rounded-md qty" min="1" required>
            </td>
            <td class="border px-4 py-2">
                <input type="number" name="items[${itemIndex}][unit_price]" class="w-30 h-7 border-gray-300 rounded-md unit-price" min="0" step="0.01" required>
            </td>
            <td class="border px-4 py-2">
                MMK<span class="line-total">0</span>
            </td>
            <td class="border px-4 py-2 text-center">
                <button type="button" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 remove-item">×</button>
            </td>
        `;
        tbody.appendChild(tr);
        itemIndex++;
    }

    document.getElementById('add-item').addEventListener('click', addRow);

    document.querySelector('#items-table').addEventListener('input', function(e) {
        if (e.target.classList.contains('qty') || e.target.classList.contains('unit-price')) {
            let row = e.target.closest('tr');
            calculateLineTotal(row);
        }
    });

    document.querySelector('#items-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('tr').remove();
            calculateGrandTotal();
        }
    });

    window.addEventListener('DOMContentLoaded', () => addRow());
</script>
@endsection
