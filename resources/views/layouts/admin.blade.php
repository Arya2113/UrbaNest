<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100" x-data="{ sidebar: true }">
    @include('partials.navbar')
    
    <div class="fixed top-0 left-0 h-full w-60 bg-gray-800 text-white" :class="{ '-translate-x-full': !sidebar }">
        <div class="flex justify-between items-center p-4">
            <h2 class="text-lg font-semibold">Admin</h2>
            <button class="md:hidden" @click="sidebar = false"><i class="fas fa-times"></i></button>
        </div>
        <ul class="mt-4">
        <li>
            <a href="/admin/transactions"
            class="block px-4 py-2 hover:bg-gray-700 {{ request()->is('admin/transactions*') ? 'bg-gray-900 font-bold' : '' }}">
            Transactions
            </a>
        </li>
        <li>
            <a href="/admin/property-visits"
            class="block px-4 py-2 hover:bg-gray-700 {{ request()->is('admin/property-visits*') ? 'bg-gray-900 font-bold' : '' }}">
            User Visits
            </a>
        </li>
        <li>
            <a href="/admin/properties"
            class="block px-4 py-2 hover:bg-gray-700 {{ request()->is('admin/properties*') ? 'bg-gray-900 font-bold' : '' }}">
            Properties
            </a>
        </li>
        </ul>
    </div>

    
    <div :class="{ 'ml-60': sidebar }" class="transition-all p-4">
        <div class="flex items-center mb-4">
            <button @click="sidebar = !sidebar" class="text-gray-600">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="ml-4 text-xl font-bold">Dashboard</h1>
        </div>

        <div class="bg-white p-4 rounded shadow">
            @yield('content')
        </div>
    </div>

</body>
</html>