@extends('layouts.master')

@section('title', 'Sale List')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Sale List</h1>

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
                    <th class="px-6 py-3 w-[18%]">Customer</th>
                    <th class="px-6 py-3 w-[10%]">Sale Date</th>
                    <th class="px-6 py-3 w-[15%]">Total Amount</th>
                    <th class="px-6 py-3 w-[37%]">Note</th>
                    <th class="px-6 py-3 w-[15%]">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sales as $sale)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-1">{{ $sale->id }}</td>
                        <td class="px-6 py-1">{{ $sale->customer->name }}</td>
                        <td class="px-6 py-1">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d-m-Y') }}</td>
                        <td class="px-6 py-1">{{ number_format($sale->total_amount) }} MMK</td>
                        <td class="px-6 py-1">{{ $sale->note ?? 'N/A' }}</td>
                        <td class="px-6 py-1 space-x-2">
                            <a href="{{ route('sales.show', $sale->id) }}"
                               class="inline-block px-4 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                View
                            </a>
                            <a href="{{ route('sales.edit', $sale->id) }}"
                               class="inline-block px-4 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-sm">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-2 py-1 text-center text-gray-500">
                            No sales found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $sales->links('pagination::tailwind') }}
    </div>
</div>
@endsection
