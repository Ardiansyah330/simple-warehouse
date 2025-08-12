@extends('layouts.admin')

@section('title', 'Transactions')

@section('content')
<div x-data="{ openAddModal: false, openEditModal: false, editData: {} }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Transactions</h2>
        <button @click="openAddModal = true" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Add Transaction
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Item</th>
                    <th class="px-4 py-2 text-left">Supplier</th>
                    <th class="px-4 py-2 text-left">Type</th>
                    <th class="px-4 py-2 text-left">Quantity</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $t->item->name }}</td>
                        <td class="px-4 py-2">{{ $t->supplier?->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ ucfirst($t->type) }}</td>
                        <td class="px-4 py-2">{{ $t->quantity }}</td>
                        <td class="px-4 py-2 flex gap-2 justify-end">
                            <button 
                                @click="openEditModal = true; editData = {
                                    id: {{ $t->id }},
                                    item_id: {{ $t->item_id }},
                                    supplier_id: {{ $t->supplier_id ?? 'null' }},
                                    type: '{{ $t->type }}',
                                    quantity: {{ $t->quantity }}
                                }"
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                Edit
                            </button>
                            <form action="{{ route('admin.transactions.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Delete this transaction?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">No transactions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Add Modal -->
    <div x-show="openAddModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Add Transaction</h3>
            <form action="{{ route('admin.transactions.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm mb-1">Item</label>
                    <select name="item_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Select Item --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Supplier</label>
                    <select name="supplier_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- None --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Type</label>
                    <select name="type" class="w-full border rounded px-3 py-2" required>
                        <option value="in">In</option>
                        <option value="out">Out</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Quantity</label>
                    <input type="number" name="quantity" class="w-full border rounded px-3 py-2" required min="1">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openAddModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="openEditModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Edit Transaction</h3>
            <form :action="`/admin/transactions/${editData.id}`" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="block text-sm mb-1">Item</label>
                    <select name="item_id" class="w-full border rounded px-3 py-2" required>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" :selected="editData.item_id === {{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Supplier</label>
                    <select name="supplier_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- None --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" :selected="editData.supplier_id === {{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Type</label>
                    <select name="type" class="w-full border rounded px-3 py-2" required>
                        <option value="in" :selected="editData.type === 'in'">In</option>
                        <option value="out" :selected="editData.type === 'out'">Out</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Quantity</label>
                    <input type="number" name="quantity" x-model="editData.quantity" class="w-full border rounded px-3 py-2" required min="1">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
