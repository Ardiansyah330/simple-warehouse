@extends('layouts.admin')

@section('content')
<div class="flex justify-between mb-4">
    <h1 class="text-2xl font-bold">Data Pesanan</h1>
    <button onclick="document.getElementById('addModal').showModal()" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Pesanan</button>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="w-full border-collapse bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="border px-4 py-2">No</th>
            <th class="border px-4 py-2">Pengguna</th>
            <th class="border px-4 py-2">Barang</th>
            <th class="border px-4 py-2">Jumlah</th>
            <th class="border px-4 py-2">Status</th>
            <th class="border px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
            <td class="border px-4 py-2">{{ $order->user->name }}</td>
            <td class="border px-4 py-2">{{ $order->item->name }}</td>
            <td class="border px-4 py-2">{{ $order->quantity }}</td>
            <td class="border px-4 py-2 capitalize">
                @if($order->status === 'pending') Menunggu
                @elseif($order->status === 'approved') Disetujui
                @elseif($order->status === 'rejected') Ditolak
                @else {{ ucfirst($order->status) }}
                @endif
            </td>
            <td class="px-4 py-2 space-x-1">
                @if($order->status === 'pending')
                    <form action="{{ route('admin.orders.approve', $order) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded">Setujui</button>
                    </form>
                    <form action="{{ route('admin.orders.reject', $order) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">Tolak</button>
                    </form>
                @endif

                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-1 rounded">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Modal Tambah --}}
<dialog id="addModal" class="p-6 bg-white rounded shadow w-96">
    <form method="POST" action="{{ route('admin.orders.store') }}" class="space-y-4">
        @csrf
        <h2 class="text-xl font-bold">Tambah Pesanan</h2>
        <div>
            <label>Pengguna</label>
            <select name="user_id" class="w-full border rounded p-2">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Barang</label>
            <select name="item_id" class="w-full border rounded p-2">
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Jumlah</label>
            <input type="number" name="quantity" class="w-full border rounded p-2">
        </div>
        <div>
            <label>Status</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="pending">Menunggu</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
        <div class="flex justify-end space-x-2">
            <button type="button" onclick="document.getElementById('addModal').close()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
        </div>
    </form>
</dialog>

{{-- Modal Edit --}}
<dialog id="editModal" class="p-6 bg-white rounded shadow w-96">
    <form method="POST" id="editForm" class="space-y-4">
        @csrf @method('PUT')
        <h2 class="text-xl font-bold">Edit Pesanan</h2>
        <div>
            <label>Pengguna</label>
            <select name="user_id" id="edit_user_id" class="w-full border rounded p-2">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Barang</label>
            <select name="item_id" id="edit_item_id" class="w-full border rounded p-2">
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Jumlah</label>
            <input type="number" name="quantity" id="edit_quantity" class="w-full border rounded p-2">
        </div>
        <div>
            <label>Status</label>
            <select name="status" id="edit_status" class="w-full border rounded p-2">
                <option value="pending">Menunggu</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
        <div class="flex justify-end space-x-2">
            <button type="button" onclick="document.getElementById('editModal').close()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Perbarui</button>
        </div>
    </form>
</dialog>

<script>
function openEditModal(id, user_id, item_id, quantity, status) {
    document.getElementById('edit_user_id').value = user_id;
    document.getElementById('edit_item_id').value = item_id;
    document.getElementById('edit_quantity').value = quantity;
    document.getElementById('edit_status').value = status;
    document.getElementById('editForm').action = '/admin/orders/' + id;
    document.getElementById('editModal').showModal();
}
</script>
@endsection
