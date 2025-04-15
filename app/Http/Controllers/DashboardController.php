<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Category;
use App\Models\SalesItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Monthly Sales & Purchases
        $monthlySales = Sale::selectRaw('MONTH(sale_date) as month, SUM(total_amount) as total')
            ->groupBy('month')->pluck('total', 'month');

        $monthlyPurchases = Purchase::selectRaw('MONTH(purchase_date) as month, SUM(total_amount) as total')
            ->groupBy('month')->pluck('total', 'month');

        // 2. Top Selling Products
        $topProducts = SalesItem::select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_qty')
            ->take(5)->get();

        // 3. Product Quantity by Category
        $categoryStock = Category::with(['products' => function ($q) {
            $q->select('id', 'category_id', 'quantity');
        }])->get()->mapWithKeys(function ($cat) {
            return [$cat->name => $cat->products->sum('quantity')];
        });

        // 4. Weekly Sales Trend
        $last7days = collect(range(0, 6))->mapWithKeys(function ($i) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $total = Sale::whereDate('sale_date', $date)->sum('total_amount');
            return [$date => $total];
        })->reverse();

        // 5. Low Stock Products
        $lowStockProducts = Product::where('quantity', '<', 101)->get();

        return view('dashboard', compact(
            'monthlySales',
            'monthlyPurchases',
            'topProducts',
            'categoryStock',
            'last7days',
            'lowStockProducts'
        ));
    }
}

