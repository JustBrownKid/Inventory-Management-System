@extends('layouts.master')

@section('title', 'Create Sale')

@section('content')

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-10">
    <!-- Chart 1 -->
    <div class="bg-white p-4 rounded-xl shadow flex flex-col items-center">
        <h3 class="text-lg font-semibold mb-2">Monthly Sales vs Purchases</h3>
        <div class="w-full h-[250px] flex justify-center items-center">
            <canvas id="salesPurchaseChart" width="400" height="250"></canvas>
        </div>
    </div>

    <!-- Chart 2 -->
    <div class="bg-white p-4 rounded-xl shadow flex flex-col items-center">
        <h3 class="text-lg font-semibold mb-2">Top Selling Products</h3>
        <div class="w-full h-[250px] flex justify-center items-center">
            <canvas id="topProductsChart" width="400" height="250"></canvas>
        </div>
    </div>

    <!-- Chart 3 -->
    <div class="bg-white p-4 rounded-xl shadow flex flex-col items-center">
        <h3 class="text-lg font-semibold mb-2">Stock by Category</h3>
        <div class="w-full h-[250px] flex justify-center items-center">
            <canvas id="categoryStockChart" width="400" height="250"></canvas>
        </div>
    </div>

    <!-- Chart 4 -->
    <div class="bg-white p-4 rounded-xl shadow flex flex-col items-center">
        <h3 class="text-lg font-semibold mb-2">Weekly Sales Trend</h3>
        <div class="w-full h-[250px] flex justify-center items-center">
            <canvas id="weeklySalesChart" width="400" height="250"></canvas>
        </div>
    </div>
    
</div>

<div class="bg-white p-4 rounded-xl shadow mb-8 mx-10">
    <h3 class="text-lg font-semibold mb-2">Low Stock Products</h3>
    <table class="w-full table-auto border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border">Product</th>
                <th class="px-4 py-2 border">Quantity</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lowStockProducts as $product)
                <tr>
                    <td class="px-4 py-2 border">{{ $product->name }}</td>
                    <td class="px-4 py-2 border text-red-500 font-bold">{{ $product->quantity }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="px-4 py-2 border text-center text-gray-400">No low stock</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    // Chart 1: Monthly Sales vs Purchases
    new Chart(document.getElementById('salesPurchaseChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($monthlySales->toArray())) !!},
            datasets: [
                {
                    label: 'Sales',
                    data: {!! json_encode(array_values($monthlySales->toArray())) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                },
                {
                    label: 'Purchases',
                    data: {!! json_encode(array_values($monthlyPurchases->toArray())) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                }
            ]
        }
    });

    // Chart 2: Top Selling Products
    new Chart(document.getElementById('topProductsChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($topProducts->pluck('product.name')->toArray()) !!},
            datasets: [{
                data: {!! json_encode($topProducts->pluck('total_qty')->toArray()) !!},
                backgroundColor: ['#4dc9f6','#f67019','#f53794','#537bc4','#acc236'],
            }]
        }
    });

    // Chart 3: Product Quantity by Category
    new Chart(document.getElementById('categoryStockChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($categoryStock->keys()) !!},
            datasets: [{
                data: {!! json_encode($categoryStock->values()) !!},
                backgroundColor: ['#ff6384','#36a2eb','#cc65fe','#ffce56','#2ecc71'],
            }]
        }
    });

    // Chart 4: Weekly Sales Trend
    new Chart(document.getElementById('weeklySalesChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($last7days->keys()) !!},
        datasets: [{
            label: 'Daily Sales',
            data: {!! json_encode($last7days->values()) !!},
            fill: true,  // Fill the area under the curve for a wave-like look
            borderColor: '#4dc9f6',  // Blue color for the line
            backgroundColor: 'rgba(77, 201, 246, 0.2)',  // Light blue background (for fill)
            tension: 0.4,  // Smooth, wave-like curve
            pointRadius: 5,  // Slightly larger points for better visualization
            pointHoverRadius: 7  // Larger points when hovering
        }]
    }
});

</script>

@endsection
