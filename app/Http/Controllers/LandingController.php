<?php

namespace App\Http\Controllers;

use App\Models\MenuProduct;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Display the main landing page
     * 
     * @return View
     */
    public function home(): View
    {
        // Get some statistics for social proof
        $stats = [
            'total_orders' => Order::count(),
            'total_products' => MenuProduct::where('is_available', true)->count(),
            'avg_preparation_time' => MenuProduct::avg('estimated_time_min') ?? 5,
        ];

        // Get featured products for showcase
        $featured_products = MenuProduct::where('is_available', true)
            ->take(6)
            ->get();

        return view('landing.home', compact('stats', 'featured_products'));
    }

    /**
     * Display the contact page
     * 
     * @return View
     */
    public function contact(): View
    {
        return view('landing.contact');
    }
}