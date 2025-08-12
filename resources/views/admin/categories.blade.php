@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
<div x-data="{ 
    openAddModal: false, 
    openEditModal: false, 
    editData: { id: '', name: '' } 
}">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Kategori</h2>
        <button @click="openAddModal = true" 
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Tambah Kategori
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-3">{{ $cat->name }}</td>
                        <td class="px-6 py-3 text-right space-x-2">
                            <button 
                                @click="openEditModal = true; editData = { 
                                    id: {{ $cat->id }}, 
                                    name: @js($cat->name) 
                                }" 
                                class="px-3 py-1.5 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                Ubah
                            </button>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1.5 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-6 text-center text-gray-500">
                            Tidak ada kategori ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah -->
    <div x-show="openAddModal" x-cloak 
         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Tambah Kategori</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Nama</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openAddModal = false" 
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div x-show="openEditModal" x-cloak 
         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Ubah Kategori</h3>
            <form :action="`{{ url('admin/categories') }}/${editData.id}`" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Nama</label>
                    <input type="text" name="name" x-model="editData.name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openEditModal = false" 
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
