<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\Warehouse;
use App\Models\Shipper;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Orders Statistics
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', Order::STATUS_PENDING)->count();
        $completedOrders = Order::where('status', Order::STATUS_COMPLETED)->count();
        $processingOrders = Order::where('status', Order::STATUS_PROCESSING)->count();
        $cancelledOrders = Order::where('status', Order::STATUS_CANCELLED)->count();
        
        // Order Financials
        $totalOrderValue = Order::sum('order_total');
        $totalPaidAmount = Order::sum('paid_amount');
        $thisMonthRevenue = Order::whereMonth('order_date', now()->month)
                                ->whereYear('order_date', now()->year)
                                ->sum('order_total');
        $todayOrders = Order::whereDate('order_date', today())->count();
        
        // Customer Statistics
        $totalCustomers = Customer::count();
        
        // Product Statistics
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<', 10)->count();
        $outOfStockProducts = Product::where('stock', '<=', 0)->count();
        
        // Category Statistics
        $totalCategories = Category::count();
        
        // Supplier & Purchase Statistics
        $totalSuppliers = Supplier::count();
        $totalPurchases = Purchase::count();
        $totalPurchaseValue = Purchase::sum('purchase_total');
        
        // Warehouse & Shipper Statistics
        $totalWarehouses = Warehouse::count();
        $totalShippers = Shipper::count();
        
        // Recent Data for Tables
        $recentOrders = Order::with('customer')
                            ->latest()
                            ->take(5)
                            ->get();
        
        $lowStockProductsList = Product::with('category')
                                    ->where('stock', '<', 10)
                                    ->orderBy('stock', 'asc')
                                    ->take(5)
                                    ->get();
        
        // Monthly Revenue Data (for potential charts)
        $monthlyRevenue = Order::selectRaw('YEAR(order_date) as year, MONTH(order_date) as month, SUM(order_total) as revenue')
                            ->whereYear('order_date', now()->year)
                            ->groupBy('year', 'month')
                            ->orderBy('year', 'desc')
                            ->orderBy('month', 'desc')
                            ->take(6)
                            ->get();
        
        // Top Selling Products
        $topSellingProducts = \App\Models\OrderDetail::selectRaw('product_id, SUM(qty) as total_sold')
                                    ->with('product')
                                    ->groupBy('product_id')
                                    ->orderBy('total_sold', 'desc')
                                    ->take(5)
                                    ->get();
        
        // Order Status Distribution
        $orderStatusDistribution = Order::selectRaw('status, COUNT(*) as count')
                                    ->groupBy('status')
                                    ->get();
        
        return view('pages.Dashboard.home', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'processingOrders',
            'cancelledOrders',
            'totalOrderValue',
            'totalPaidAmount',
            'thisMonthRevenue',
            'todayOrders',
            'totalCustomers',
            'totalProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'totalCategories',
            'totalSuppliers',
            'totalPurchases',
            'totalPurchaseValue',
            'totalWarehouses',
            'totalShippers',
            'recentOrders',
            'lowStockProductsList',
            'monthlyRevenue',
            'topSellingProducts',
            'orderStatusDistribution'
        ));
    }
}