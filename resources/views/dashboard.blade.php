@extends('layouts.master')

@section('title', 'Create Sale')

@section('content')

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-10">

    <!-- Chart 1: Monthly Sales vs Purchases -->
    <div class="bg-white p-6 rounded-xl shadow flex flex-col">
        <h3 class="text-lg font-semibold mb-4 text-center">Monthly Sales vs Purchases</h3>
        <div class="h-[200px] flex justify-center items-center">
            <canvas width="600" height="350" id="salesPurchaseChart"></canvas>
        </div>
    </div>

    <!-- Chart 2: Top Selling Products -->
    <div class="bg-white p-6 rounded-xl shadow flex flex-col">
        <h3 class="text-lg font-semibold mb-4 text-center">Top Selling Products</h3>
        <div class="bg-white px-8 flex flex-row gap-2">
            <div class="w-full lg:w-[65%] flex justify-start items-center">
                <div class="relative flex justify-center items-center">
                    <canvas id="topProductsChart" width="220" height="220"></canvas>
                </div>
            </div>
            <!-- Top Products Legend (Aligned to the right) -->
            <div class="w-full lg:w-[35%] max-h-[230px] overflow-y-auto pr-2" id="topProductsLegend"></div>
        </div>
    </div>

    <!-- Chart 3: Stock by Category -->
    <div class="bg-white p-6 rounded-xl shadow flex flex-col">
        <h3 class="text-lg font-semibold mb-4 text-center">Top Selling Products</h3>
        <div class="bg-white px-8 flex flex-row gap-2">
            <div class="w-full lg:w-[65%] flex justify-start items-center">
                <div class="relative flex justify-center items-center">
                    <canvas id="categoryStockChart" width="220" height="220"></canvas>
                </div>
            </div>
            <!-- Top Products Legend (Aligned to the right) -->
            <div class="w-full lg:w-[35%] max-h-[230px] overflow-y-auto pr-2" id="categoryLegend"></div>
        </div>
    </div>
    <!-- Chart 4: Weekly Sales Trend -->
    <div class="bg-white p-6 rounded-xl shadow flex flex-col">
        <h3 class="text-lg font-semibold mb-4 text-center">Weekly Sales Trend</h3>
        <div class="h-[250px] flex justify-center items-center">
            <canvas id="weeklySalesChart"></canvas>
        </div>
    </div>

</div>

<!-- Low Stock Table -->
<div class="bg-white p-6 rounded-xl shadow mb-8 mx-10">
    <h3 class="text-lg font-semibold mb-4">Low Stock Products</h3>
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
    // Helper: Generate dynamic color list
    function generateColors(count) {
        const baseColors = [
            '#4dc9f6','#f67019','#f53794','#537bc4','#acc236',
            '#ff6384','#36a2eb','#cc65fe','#ffce56','#2ecc71',
            '#3498db','#9b59b6','#e74c3c','#1abc9c','#f1c40f',
            '#95a5a6','#8e44ad','#d35400','#2c3e50','#27ae60'
        ];
        while (baseColors.length < count) {
            const randomColor = '#' + Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0');
            baseColors.push(randomColor);
        }
        return baseColors.slice(0, count);
    }

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
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            }
        }
    });

    // Chart 2: Top Selling Products
    const topProductLabels = {!! json_encode($topProducts->pluck('product.name')->toArray()) !!};
    const topProductData = {!! json_encode($topProducts->pluck('total_qty')->toArray()) !!};
    const topColors = generateColors(topProductLabels.length);

    new Chart(document.getElementById('topProductsChart'), {
        type: 'doughnut',
        data: {
            labels: topProductLabels,
            datasets: [{
                data: topProductData,
                backgroundColor: topColors,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    document.getElementById('topProductsLegend').innerHTML = topProductLabels.map((label, i) => `
        <div class="flex items-center mb-2">
            <div style="width: 10px; height: 14px; background-color: ${topColors[i]}; margin-right: 8px; border-radius: 3px;"></div>
            <span class="text-sm">${label}</span>
        </div>
    `).join('');

    // Chart 3: Stock by Category
    const categoryLabels = {!! json_encode($categoryStock->keys()) !!};
    const categoryData = {!! json_encode($categoryStock->values()) !!};
    const catColors = generateColors(categoryLabels.length);

    new Chart(document.getElementById('categoryStockChart'), {
        type: 'pie',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                backgroundColor: catColors,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    document.getElementById('categoryLegend').innerHTML = categoryLabels.map((label, i) => `
        <div class="flex items-center mb-2">
            <div style="width: 10px; height: 14px; background-color: ${catColors[i]}; margin-right: 8px; border-radius: 3px;"></div>
            <span class="text-sm">${label}</span>
        </div>
    `).join('');

    // Chart 4: Weekly Sales Trend
    new Chart(document.getElementById('weeklySalesChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($last7days->keys()) !!},
            datasets: [{
                label: 'Daily Sales',
                data: {!! json_encode($last7days->values()) !!},
                fill: true,
                borderColor: '#4dc9f6',
                backgroundColor: 'rgba(77, 201, 246, 0.2)',
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            }
        }
    });
</script>

@endsection
