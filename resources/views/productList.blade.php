@extends('layouts.master')

@section('title', 'cation') 

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
    <h1 class="text-2xl font-bold tracking-wide"> Product List</h1>
</div>

<div class="container mx-auto p-4">


  
    <div class="overflow-x-auto">
    <div class="flex justify-between mb-4">
        <input id="search" type="text" placeholder="Enter products name or SKU" class="w-1/3 p-2 border border-gray-300 rounded-md" />
        <select id="filter" class="p-2 border border-gray-300 rounded-md">
            <option value="">All Categories</option>
            
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
  <div class="max-h-[580px] overflow-y-auto">
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
      <thead class="bg-gray-500 text-gray-700 sticky  border-gray-300 top-0 z-100">
        <tr>
          <th class="p-2 text-left bg-gray-100 border border-gray-300 w-48">Product Name</th>
          <th class="p-2 text-left bg-gray-100 border border-gray-300 w-32">SKU</th>
          <th class="p-2 text-left bg-gray-100 border border-gray-300 w-40">Category</th>
          <th class="p-2 text-left bg-gray-100 border border-gray-300 w-24">Price</th>
          <th class="p-2 text-left bg-gray-100 border border-gray-300 w-24">Quantity</th>
          <th class="p-2 text-left bg-gray-100 border border-gray-300 w-[200px]">Description</th>
          <th class="p-2 text-left bg-gray-100 border border-gray-300 w-[160px]">Action</th>
        </tr>
      </thead>
      <tbody id="product-table-body" class="divide-y divide-gray-200">
        <!-- Rows rendered here with JavaScript -->
      </tbody>
    </table>
  </div>
</div>

<script>
    const products = {!! json_encode($products) !!};
    const categories = {!! json_encode($categories) !!}; 
    const categoryColors = {
        1: 'bg-blue-200',
        2: 'bg-green-200',
        3: 'bg-yellow-200',
    };

    const productTableBody = document.getElementById("product-table-body");
    const searchInput = document.getElementById("search");
    const filterSelect = document.getElementById("filter");

        function renderTable(filteredData) {
    productTableBody.innerHTML = ''; 
    filteredData.forEach(product => {
        const row = document.createElement("tr");
        row.classList.add("border-b");

        const category = categories.find(cat => cat.id == product.category_id);
        const categoryName = category ? category.name : 'Unknown';
        const categoryColor = categoryColors[product.category_id] || 'bg-gray-200'; 

        row.innerHTML = `
            <td class="p-2 border border-gray-300">${product.name}</td>
<td class="p-2 border border-gray-300">${product.sku}</td>
<td class="p-2 border border-gray-300 ${categoryColor}">${categoryName}</td>
<td class="p-2 border border-gray-300">${product.price}</td>
<td class="p-2 border border-gray-300">${product.quantity}</td>
<td class="p-2 border border-gray-300">${product.description}</td>
<td class="p-2 border border-gray-300">
  <a href="/products/${product.id}/edit" 
     class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded mr-2 text-sm">
     Edit
  </a>
  <form action="/product/${product.id}/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline-block">
    @csrf
    @method('DELETE')
    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">
      Delete
    </button>
  </form>
</td>

        `;
        productTableBody.appendChild(row);
    });
}

        function filterData() {
            let filteredData = [...products];

        
            const selectedCategory = filterSelect.value;
            if (selectedCategory) {
                filteredData = filteredData.filter(product => product.category_id == selectedCategory);
            }

        
            const searchQuery = searchInput.value.toLowerCase();
            if (searchQuery) {
                filteredData = filteredData.filter(product =>
                    product.name.toLowerCase().includes(searchQuery) ||
                    product.sku.toLowerCase().includes(searchQuery) ||
                    product.description.toLowerCase().includes(searchQuery)
                );
            }

            renderTable(filteredData);
        }

        renderTable(products);

        searchInput.addEventListener("input", filterData);
        filterSelect.addEventListener("change", filterData);
    </script>
@endsection
