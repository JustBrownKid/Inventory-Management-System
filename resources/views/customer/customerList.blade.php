@extends('layouts.master')

@section('title', 'Customer List')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Customer List</h1>

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <input id="search" type="text" placeholder="Search by name, email, phone, or address"
               class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th class="px-6 py-3">Customer Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Phone</th>
                    <th class="px-6 py-3">Address</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="customer-table-body">
                <!-- Dynamic customer rows inserted here -->
            </tbody>
        </table>
    </div>
</div>

<script>
    const customers = @json($customers);
    const customerTableBody = document.getElementById("customer-table-body");
    const searchInput = document.getElementById("search");

    function renderTable(filteredData) {
        customerTableBody.innerHTML = '';
        if (filteredData.length === 0) {
            customerTableBody.innerHTML = ` 
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        No customers found.
                    </td>
                </tr>`;
            return;
        }

        filteredData.forEach(customer => {
            const row = document.createElement("tr");
            row.classList.add("border-b", "hover:bg-gray-50");

            row.innerHTML = `
                <td class="px-6 py-1">${customer.name}</td>
                <td class="px-6 py-1">${customer.email}</td>
                <td class="px-6 py-1">${customer.phone}</td>
                <td class="px-6 py-1">${customer.address}</td>
                <td class="px-6 py-1 space-x-2">
                    <a href="/customer/${customer.id}/edit"
                       class="inline-block px-4 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                        <i class="fas fa-edit"></i> 
                    </a>
                    <form action="/customer/${customer.id}/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?');" class="inline-block">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="inline-block px-4 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                            <i class="fas fa-trash-alt"></i> 
                        </button>
                    </form>
                </td>
            `;
            customerTableBody.appendChild(row);
        });
    }

    function filterData() {
        let query = searchInput.value.toLowerCase();
        const filtered = customers.filter(customer =>
            customer.name.toLowerCase().includes(query) ||
            customer.email.toLowerCase().includes(query) ||
            customer.phone.toLowerCase().includes(query) ||
            customer.address.toLowerCase().includes(query)
        );
        renderTable(filtered);
    }

    renderTable(customers);
    searchInput.addEventListener("input", filterData);
</script>

<!-- Font Awesome CDN for Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

@endsection
