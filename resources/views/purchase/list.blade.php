@extends('layouts.master')

@section('title', 'Purchase List')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Purchase List</h1>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th class="px-6 py-3 w-[5%]"> ID</th>
                    <th class="px-6 py-3 w-[18%]">Supplier</th>
                    <th class="px-6 py-3 w-[10%]">Purchase Date</th>
                    <th class="px-6 py-3 w-[15%]">Total Amount</th>
                    <th class="px-6 py-3 w-[37%]">Note</th>
                    <th class="px-6 py-3 w-[15%]">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchases as $purchase)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-1">{{ $purchase->id }}</td>
                        <td class="px-6 py-1">{{ $purchase->supplier->name }}</td>
                        <td class="px-6 py-1">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-m-Y') }}</td>
                        <td class="px-6 py-1">{{ number_format($purchase->total_amount) }} MMK</td>


                        <td class="px-6 py-1">{{ $purchase->note ?? 'N/A' }}</td>
                        <td class="px-6 py-1 space-x-2">
                            <a href="{{ route('purchases.show', $purchase->id) }}"
                               class="inline-block px-4 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                View
                            </a>
                            <a href="{{ route('purchases.edit', $purchase->id) }}"
                               class="inline-block px-4 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-sm">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-2 py-1 text-center text-gray-500">
                            No purchases found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $purchases->links('pagination::tailwind') }}
    </div>
</div>
@endsection
