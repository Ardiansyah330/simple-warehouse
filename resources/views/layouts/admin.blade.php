<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dasbor')</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white min-h-screen">
        <div class="p-4 text-xl font-bold border-b border-gray-700">Warehouse</div>
        <nav class="p-4 space-y-2">
            <a href="/admin" class="block px-3 py-2 rounded hover:bg-white hover:text-gray-800">Dashboard</a>
            <a href="/admin/items" class="block px-3 py-2 rounded hover:bg-white hover:text-gray-800">Barang</a>
            <a href="/admin/categories" class="block px-3 py-2 rounded hover:bg-white hover:text-gray-800">Kategori</a>
            <a href="/admin/suppliers" class="block px-3 py-2 rounded hover:bg-white hover:text-gray-800">Supplier</a>
            <a href="/admin/transactions" class="block px-3 py-2 rounded hover:bg-white hover:text-gray-800">Transaksi</a>
            <a href="/admin/orders" class="block px-3 py-2 rounded hover:bg-white hover:text-gray-800">Pesanan</a>
        </nav>
    </aside>

    <!-- Konten -->
    <div class="flex-1 flex flex-col">
        <!-- Topbar -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold">@yield('title')</h1>
            <div class="flex items-center gap-4">
                <span>{{ auth()->user()->name ?? 'Tamu' }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Keluar</button>
                </form>
            </div>
        </header>

        <!-- Konten Utama -->
        <main class="p-6 flex-1">
            @yield('content')
        </main>
    </div>

</body>
</html>
