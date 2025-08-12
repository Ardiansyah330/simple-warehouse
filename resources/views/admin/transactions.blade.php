@extends('layouts.admin')

@section('title', 'Transaksi')

@section('content')
<div x-data="{ openAddModal: false, openEditModal: false, editData: {} }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Daftar Transaksi</h2>
        <button @click="openAddModal = true" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Tambah Transaksi
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
                    <th class="px-4 py-2 text-left">Barang</th>
                    <th class="px-4 py-2 text-left">Supplier</th>
                    <th class="px-4 py-2 text-left">Jenis</th>
                    <th class="px-4 py-2 text-left">Jumlah</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $t->item->name }}</td>
                        <td class="px-4 py-2">{{ $t->supplier?->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $t->type === 'in' ? 'Masuk' : 'Keluar' }}</td>
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
                            <form action="{{ route('admin.transactions.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">Tidak ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div x-show="openAddModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Tambah Transaksi</h3>
            <form action="{{ route('admin.transactions.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm mb-1">Barang</label>
                    <select name="item_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Supplier</label>
                    <select name="supplier_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Jenis Transaksi</label>
                    <select name="type" class="w-full border rounded px-3 py-2" required>
                        <option value="in">Masuk</option>
                        <option value="out">Keluar</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Jumlah</label>
                    <input type="number" name="quantity" class="w-full border rounded px-3 py-2" required min="1">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openAddModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div x-show="openEditModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Edit Transaksi</h3>
            <form :action="`/admin/transactions/${editData.id}`" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="block text-sm mb-1">Barang</label>
                    <select name="item_id" class="w-full border rounded px-3 py-2" required>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" :selected="editData.item_id === {{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Supplier</label>
                    <select name="supplier_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" :selected="editData.supplier_id === {{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Jenis Transaksi</label>
                    <select name="type" class="w-full border rounded px-3 py-2" required>
                        <option value="in" :selected="editData.type === 'in'">Masuk</option>
                        <option value="out" :selected="editData.type === 'out'">Keluar</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm mb-1">Jumlah</label>
                    <input type="number" name="quantity" x-model="editData.quantity" class="w-full border rounded px-3 py-2" required min="1">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
