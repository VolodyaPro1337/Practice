<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Configuration;
use App\Models\Material;
use App\Models\Order;
use App\Models\Product;
use App\Models\Profile;
use App\Models\AutomationOption;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'orders' => Order::count(),
            'new_orders' => Order::where('status', 'new')->count(),
            'configurations' => Configuration::count(),
            'categories' => Category::count(),
            'products' => Product::count(),
            'profiles' => Profile::count(),
            'materials' => Material::count(),
            'automation_options' => AutomationOption::count(),
        ];

        $recentOrders = Order::with(['configuration.profile', 'configuration.material'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
