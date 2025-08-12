@extends('layouts.admin')

@section('title', 'Supplier')

@section('content')
<div x-data="{ openAddModal: false, openEditModal: false, editData: {} }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Supplier</h2>
        <button @click="openAddModal = true" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Tambah Supplier
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Telepon</th>
                    <th class="px-4 py-2 text-left">Alamat</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $supplier->name }}</td>
                        <td class="px-4 py-2">{{ $supplier->email ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $supplier->phone ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $supplier->address ?? '-' }}</td>
                        <td class="px-4 py-2 flex justify-end gap-2">
                            <button 
                                @click="openEditModal = true; editData = {{ json_encode($supplier) }}"
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                            >Ubah</button>
                            <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Hapus pemasok ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">Tidak ada supplier</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div x-show="openAddModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Tambah Supplier</h3>
            <form action="{{ route('admin.suppliers.store') }}" method="POST">
                @csrf
                @include('components.supplier-form', ['edit' => false])
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openAddModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ubah -->
    <div x-show="openEditModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Ubah Pemasok</h3>
            <form :action="`/admin/suppliers/${editData.id}`" method="POST">
                @csrf
                @method('PUT')
                @include('components.supplier-form', ['edit' => true])
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
