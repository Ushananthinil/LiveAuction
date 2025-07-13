<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Live Auction') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 antialiased font-sans">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg border-r">
            <div class="h-16 flex items-center justify-center border-b bg-indigo-600 text-white font-bold text-xl">
                Live Auction
            </div>
            <nav class="p-4 space-y-2 text-sm">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('products.index') }}" class="block text-gray-700 hover:bg-indigo-100 p-2 rounded transition">🛍️ Products</a>
                        <a href="#" class="block text-gray-700 hover:bg-indigo-100 p-2 rounded transition">📈 Bids</a>
                        <a href="#" class="block text-gray-700 hover:bg-indigo-100 p-2 rounded transition">👥 Users</a>
                    @elseif(auth()->user()->role === 'bidder')
                        <a href="#" class="block text-gray-700 hover:bg-indigo-100 p-2 rounded transition">🎯 Live Auctions</a>
                        <a href="#" class="block text-gray-700 hover:bg-indigo-100 p-2 rounded transition">💰 My Bids</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full text-left p-2 text-red-600 hover:bg-red-100 rounded transition">🚪 Logout</button>
                    </form>
                @endauth
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">
            @if (isset($header))
                <div class="mb-6">
                    {{ $header }}
                </div>
            @endif

            {{ $slot }}
        </main>

    </div>
</body>
</html>
