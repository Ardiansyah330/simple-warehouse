@extends('layouts.admin')

@section('title', 'Dasbor')

@section('content')
<div class="grid grid-cols-4 gap-6">
    <div class="bg-white shadow p-4 rounded">
        <h2 class="text-sm font-bold text-gray-500">Total Barang</h2>
        <p class="text-2xl font-bold mt-2">{{ $totalItems }}</p>
    </div>
    <div class="bg-white shadow p-4 rounded">
        <h2 class="text-sm font-bold text-gray-500">Total Pesanan</h2>
        <p class="text-2xl font-bold mt-2">{{ $totalOrders }}</p>
    </div>
    <div class="bg-white shadow p-4 rounded">
        <h2 class="text-sm font-bold text-gray-500">Total Pemasok</h2>
        <p class="text-2xl font-bold mt-2">{{ $totalSuppliers }}</p>
    </div>
    <div class="bg-white shadow p-4 rounded">
        <h2 class="text-sm font-bold text-gray-500">Total Transaksi</h2>
        <p class="text-2xl font-bold mt-2">{{ $totalTransactions }}</p>
    </div>
</div>
@endsection
