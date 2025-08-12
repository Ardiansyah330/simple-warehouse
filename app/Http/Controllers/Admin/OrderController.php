<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'item'])->latest()->get();
        $users = User::all();
        $items = Item::all();

        return view('admin.orders', compact('orders', 'users', 'items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        Order::create($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order added successfully.');
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    public function approve(Order $order)
    {
        $order->update(['status' => 'approved']);
        return redirect()->route('admin.orders.index')->with('success', 'Order approved successfully.');
    }

    public function reject(Order $order)
    {
        $order->update(['status' => 'rejected']);
        return redirect()->route('admin.orders.index')->with('success', 'Order rejected successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
