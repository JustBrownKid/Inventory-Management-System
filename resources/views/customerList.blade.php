@extends('layouts.master')

@section('title', 'Customer List') 

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

<div class="w-full bg-slate-500 p-3 text-white text-center">
    <h1 class="text-2xl font-bold tracking-wide">Customer List</h1>
</div>

<div class="container mx-auto p-4">
    <div class="overflow-x-auto">
        <div class="flex justify-between mb-4">
            <input id="search" type="text" placeholder="Enter customer name or email" class="w-1/3 p-2 border border-gray-300 rounded-md" />
        </div>

        <div class="max-h-[580px] overflow-y-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-500 text-gray-700 sticky border-gray-300 top-0 z-100">
                    <tr>
                        <th class="p-2 text-left bg-gray-100 border border-gray-300 w-48">Customer Name</th>
                        <th class="p-2 text-left bg-gray-100 border border-gray-300 w-48">Email</th>
                        <th class="p-2 text-left bg-gray-100 border border-gray-300 w-32">Phone</th>
                        <th class="p-2 text-left bg-gray-100 border border-gray-300 w-60">Address</th>
                        <th class="p-2 text-left bg-gray-100 border border-gray-300 w-[160px]">Action</th>
                    </tr>
                </thead>
                <tbody id="customer-table-body" class="divide-y divide-gray-200">
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
            filteredData.forEach(customer => {
                const row = document.createElement("tr");
                row.classList.add("border-b");

                row.innerHTML = `
                    <td class="p-2 border border-gray-300">${customer.name}</td>
                    <td class="p-2 border border-gray-300">${customer.email}</td>
                    <td class="p-2 border border-gray-300">${customer.phone}</td>
                    <td class="p-2 border border-gray-300">${customer.address}</td>
                    <td class="p-2 border border-gray-300">
                        <a href="/customer/${customer.id}/edit" 
                           class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded mr-2 text-sm">
                           Edit
                        </a>
                        <form action="/customer/${customer.id}/delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?');" class="inline-block">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded text-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                `;
                customerTableBody.appendChild(row);
            });
        }

        function filterData() {
            let filteredData = [...customers];
            const query = searchInput.value.toLowerCase();

            if (query) {
                filteredData = filteredData.filter(customer =>
                    customer.name.toLowerCase().includes(query) ||
                    customer.email.toLowerCase().includes(query) ||
                    customer.phone.toLowerCase().includes(query) ||
                    customer.address.toLowerCase().includes(query)
                );
            }

            renderTable(filteredData);
        }

        renderTable(customers);
        searchInput.addEventListener("input", filterData);
    </script>
</div>
@endsection
