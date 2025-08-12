<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['item', 'supplier'])->latest()->get();
        $items = Item::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.transactions', compact('transactions', 'items', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1'
        ]);

        $transaction = Transaction::create($request->all());

        // Update stock item
        if ($transaction->type === 'in') {
            $transaction->item->increment('stock', $transaction->quantity);
        } else {
            $transaction->item->decrement('stock', $transaction->quantity);
        }

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction added successfully.');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1'
        ]);

        // Kembalikan stok lama
        if ($transaction->type === 'in') {
            $transaction->item->decrement('stock', $transaction->quantity);
        } else {
            $transaction->item->increment('stock', $transaction->quantity);
        }

        $transaction->update($request->all());

        // Update stok baru
        if ($transaction->type === 'in') {
            $transaction->item->increment('stock', $transaction->quantity);
        } else {
            $transaction->item->decrement('stock', $transaction->quantity);
        }

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        // Kembalikan stok sebelum hapus
        if ($transaction->type === 'in') {
            $transaction->item->decrement('stock', $transaction->quantity);
        } else {
            $transaction->item->increment('stock', $transaction->quantity);
        }

        $transaction->delete();
        return redirect()->route('admin.transactions.index')->with('success', 'Transaction deleted successfully.');
    }
}
