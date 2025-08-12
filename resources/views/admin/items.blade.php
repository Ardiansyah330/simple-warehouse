@extends('layouts.admin')

@section('title', 'Items')

@section('content')
<div x-data="{ openAddModal: false, openEditModal: false, editData: {} }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Items</h2>
        <button @click="openAddModal = true" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Add Item
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
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Category</th>
                    <th class="px-4 py-2 text-left">Stock</th>
                    <th class="px-4 py-2 text-left">Price</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->name }}</td>
                        <td class="px-4 py-2">{{ $item->category->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $item->stock }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <button 
                                @click="openEditModal = true; editData = {id: {{ $item->id }}, name: '{{ addslashes($item->name) }}', category_id: {{ $item->category_id }}, stock: {{ $item->stock }}, price: {{ $item->price }}}"
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                            >Edit</button>
                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this item?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">No items found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Add Modal -->
    <div x-show="openAddModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Add Item</h3>
            <form action="{{ route('admin.items.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block mb-1">Name</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Category</label>
                    <select name="category_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Stock</label>
                    <input type="number" name="stock" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Price</label>
                    <input type="number" name="price" step="0.01" class="w-full border rounded px-3 py-2" required>
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
            <h3 class="text-lg font-semibold mb-4">Edit Item</h3>
            <form :action="`/admin/items/${editData.id}`" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="block mb-1">Name</label>
                    <input type="text" name="name" x-model="editData.name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Category</label>
                    <select name="category_id" x-model="editData.category_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Stock</label>
                    <input type="number" name="stock" x-model="editData.stock" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1">Price</label>
                    <input type="number" name="price" step="0.01" x-model="editData.price" class="w-full border rounded px-3 py-2" required>
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
