@extends('layouts.master')

@section('title', 'Product List')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Product List</h1>

    @if(session('success'))
        <div id="toast" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-md transition-opacity">
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

    <div class="flex justify-between mb-4">
        <input id="search" type="text" placeholder="Enter product name, SKU, or description"
               class="w-1/3 p-2 border border-gray-300 rounded-md shadow-sm" />
        <select id="filter" class="p-2 border border-gray-300 rounded-md shadow-sm">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th class="px-6 py-3">Product Name</th>
                    <th class="px-6 py-3">SKU</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3">Price</th>
                    <th class="px-6 py-3">Quantity</th>
                    <th class="px-6 py-3">Description</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="product-table-body">
                {{-- Rendered by JS --}}
            </tbody>
        </table>
    </div>
</div>

<script>
    const products = {!! json_encode($products) !!};
    const categories = {!! json_encode($categories) !!};
    const categoryColors = {
        1: 'bg-blue-100', 2: 'bg-green-100', 3: 'bg-yellow-100', 4: 'bg-red-100',
        5: 'bg-purple-100', 6: 'bg-pink-100', 7: 'bg-indigo-100', 8: 'bg-teal-100',
        9: 'bg-orange-100', 10: 'bg-gray-100'
        // Add more if needed
    };

    const productTableBody = document.getElementById("product-table-body");
    const searchInput = document.getElementById("search");
    const filterSelect = document.getElementById("filter");

    function renderTable(filteredData) {
        productTableBody.innerHTML = '';
        filteredData.forEach(product => {
            const row = document.createElement("tr");
            row.classList.add("border-b", "hover:bg-gray-50");

            const category = categories.find(cat => cat.id == product.category_id);
            const categoryName = category ? category.name : 'Unknown';
            const categoryColor = categoryColors[product.category_id] || 'bg-gray-100';

            row.innerHTML = `
                <td class="px-6 py-1">${product.name}</td>
                <td class="px-6 py-1">${product.sku}</td>
                <td class="px-6 py-1 ${categoryColor} ">${categoryName}</td>
                <td class="px-6 py-1">${product.price}</td>
                <td class="px-6 py-1">${product.quantity}</td>
                <td class="px-6 py-1">${product.description}</td>
                <td class="px-6 py-1 space-x-2">
                    <a href="/products/${product.id}/edit"
                       class="inline-block px-4 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                        Edit
                    </a>
                    <form action="/product/${product.id}/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-block px-4 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                            Delete
                        </button>
                    </form>
                </td>
            `;
            productTableBody.appendChild(row);
        });
    }

    function filterData() {
        let filtered = [...products];

        const selectedCategory = filterSelect.value;
        if (selectedCategory) {
            filtered = filtered.filter(p => p.category_id == selectedCategory);
        }

        const query = searchInput.value.toLowerCase();
        if (query) {
            filtered = filtered.filter(p =>
                p.name.toLowerCase().includes(query) ||
                p.sku.toLowerCase().includes(query) ||
                p.description.toLowerCase().includes(query)
            );
        }

        renderTable(filtered);
    }

    renderTable(products);
    searchInput.addEventListener("input", filterData);
    filterSelect.addEventListener("change", filterData);
</script>
@endsection
