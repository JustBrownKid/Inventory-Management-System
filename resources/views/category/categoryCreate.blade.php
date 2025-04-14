@extends('layouts.master')

@section('title', 'Create Category') 

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
    <h1 class="text-2xl font-bold tracking-wide">Category Selection</h1>
</div>

<div class="container mx-auto px-24">
    <form action="{{ route('category.store') }}" method="POST" class="p-4">
        @csrf
        <div class="flex gap-4 flex-wrap items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                <input 
                    type="text" 
                    name="name" 
                    required
                    placeholder="Enter category name" 
                    value="{{ old('name') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2"
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <input 
                    type="text" 
                    name="description" 
                    required
                    placeholder="Enter description" 
                    value="{{ old('description') }}" 
                    class="w-full border border-gray-300 rounded px-3 py-2"
                >
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="pt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-8 rounded">
                    Create Category
                </button>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input
                    type="text"
                    id="search-category"
                    placeholder="Search Categories..."
                    class="w-full p-2 border border-gray-300 rounded-md"
                />
            </div>
        </div>
    </form>
</div>


<div class="p-4">
<div class="max-h-[530px] overflow-y-auto">
  <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
    <thead class="bg-gray-500 text-gray-700 sticky top-0 z-100">
      <tr>
        <th class="p-2 text-left bg-gray-100 border border-gray-300 w-20">ID</th>
        <th class="p-2 text-left bg-gray-100 border border-gray-300 w-40">Category Name</th>
        <th class="p-2 text-left bg-gray-100 border border-gray-300 w-25">Description</th>
        <th class="p-2 text-left bg-gray-100 border border-gray-300 w-40">Created At</th>
        <th class="p-2 text-left bg-gray-100 border border-gray-300 w-40">Update At</th>
        <th class="p-2 text-left bg-gray-100 border border-gray-300 w-40">Action</th>
      </tr>
    </thead>
    <tbody id="category-table-body" class="divide-y divide-gray-200">
   
    </tbody>
  </table>
</div>
</div>
<script>
  const categories = {!! json_encode($categories) !!};
  const categoryTableBody = document.getElementById("category-table-body");
  const searchCategoryInput = document.getElementById("search-category");

  function renderTable(filteredCategories) {
  categoryTableBody.innerHTML = ''; 
  filteredCategories.forEach((category, index) => {
    const row = document.createElement("tr");
    row.classList.add("border-b");

    const createdAt = category.created_at
      ? new Date(category.created_at).toLocaleDateString()
      : 'N/A';
      const updatedAt = category.updated_at
      ? new Date(category.updated_at).toLocaleDateString()
      : 'N/A';
    row.innerHTML = `
      <td class="p-2 border border-gray-300">${index + 1}</td> <!-- Index number -->
      <td class="p-2 border border-gray-300">${category.name}</td>
        <td class="p-2 border border-gray-300">${category.description}</td>
        <td class="p-2 border border-gray-300">${createdAt}</td>
        <td class="p-2 border border-gray-300">${updatedAt}</td>
        <td class="p-2 border border-gray-300">
          <a href="/category/${category.id}/edit" 
   class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded mr-2 text-sm">
   Edit
</a>

          <form action="/categories/${category.id}/delete" method="POST" 
                onsubmit="return confirm('Are you sure you want to delete this category?');" 
                class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">
              Delete
            </button>
          </form>
        </td>
      `;

      categoryTableBody.appendChild(row);
    });
  }

  function filterCategories() {
    const query = searchCategoryInput.value.toLowerCase();
    const filteredCategories = categories.filter(category => {
      return (
        category.name.toLowerCase().includes(query) ||
        category.description.toLowerCase().includes(query)
      );
    });

    renderTable(filteredCategories);
  }

  
  renderTable(categories);

 
  searchCategoryInput.addEventListener("input", filterCategories);
</script>

@endsection
