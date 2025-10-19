<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Order;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $stats = [
            'total_posts' => Post::count(),
            'total_games' => Game::count(),
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'paid_orders' => Order::where('status', 'paid')->count(),
        ];

        $recent_orders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $upcoming_games = Game::with('stadium')
            ->where('start_at', '>', now())
            ->orderBy('start_at', 'asc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'upcoming_games'));
    }
}