<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'products' => Product::count(),
                'activeProducts' => Product::where('active', true)->count(),
                'unreadMessages' => ContactMessage::whereNull('read_at')->count(),
                'totalMessages' => ContactMessage::count(),
            ],
        ]);
    }
}
