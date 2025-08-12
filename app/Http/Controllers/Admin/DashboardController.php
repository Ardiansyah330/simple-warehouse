<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use App\Models\Supplier;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $totalOrders = Order::count();
        $totalSuppliers = Supplier::count();
        $totalTransactions = Transaction::count();

        return view('admin.dashboard', compact(
            'totalItems',
            'totalOrders',
            'totalSuppliers',
            'totalTransactions'
        ));
    }
}
