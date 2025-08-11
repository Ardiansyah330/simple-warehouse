@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-4 gap-6">
    <div class="bg-white shadow p-4 rounded">
        <h2 class="text-sm font-bold text-gray-500">Total Items</h2>
        <p class="text-2xl font-bold mt-2">120</p>
    </div>
    <div class="bg-white shadow p-4 rounded">
        <h2 class="text-sm font-bold text-gray-500">Orders</h2>
        <p class="text-2xl font-bold mt-2">45</p>
    </div>
    <div class="bg-white shadow p-4 rounded">
        <h2 class="text-sm font-bold text-gray-500">Suppliers</h2>
        <p class="text-2xl font-bold mt-2">10</p>
    </div>
    <div class="bg-white shadow p-4 rounded">
        <h2 class="text-sm font-bold text-gray-500">Transactions</h2>
        <p class="text-2xl font-bold mt-2">80</p>
    </div>
</div>
@endsection
