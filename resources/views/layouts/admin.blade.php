<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-yestosa-bakery.png') }}">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-zinc-50 text-zinc-900">
    <header class="border-b bg-white" x-data="{ open: false }">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Brand --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-bold">
                    <img src="{{ asset('images/logo-yestosa-bakery.png') }}" alt="Yestosa Bakery" class="h-10 w-10 rounded-full object-cover">
                    <span>Yestosa Bakery</span>
                </a>


                {{-- Desktop Nav --}}
                <nav class="hidden md:flex text-sm text-zinc-600 gap-4">
                    <a class="hover:text-zinc-900" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="hover:text-zinc-900" href="{{ route('admin.categories.index') }}">Kategori</a>
                    <a class="hover:text-zinc-900" href="{{ route('admin.products.index') }}">Produk</a>
                </nav>
            </div>

            {{-- Right side desktop --}}
            <div class="hidden md:flex items-center gap-3">
                <div class="text-sm text-zinc-600">{{ auth()->user()->name }}</div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm px-3 py-1.5 rounded border bg-white hover:bg-zinc-100">
                        Logout
                    </button>
                </form>
            </div>

            {{-- Hamburger (Mobile) --}}
            <button type="button"
                class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded border text-zinc-700"
                @click="open = !open"
                aria-label="Toggle menu">
                ☰
            </button>
        </div>

        {{-- Mobile Panel --}}
        <div x-show="open"
            x-transition
            @click.outside="open = false"
            class="md:hidden border-t bg-white">
            <div class="max-w-6xl mx-auto px-6 py-4 space-y-3 text-sm">

                <a class="block text-zinc-700" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="block text-zinc-700" href="{{ route('admin.categories.index') }}">Kategori</a>
                <a class="block text-zinc-700" href="{{ route('admin.products.index') }}">Produk</a>

                <hr>

                <div class="text-sm text-zinc-600">{{ auth()->user()->name }}</div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-left text-zinc-500">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>


    <main class="max-w-6xl mx-auto px-6 py-8">
        @if (session('success'))
        <div class="mb-6 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
        @endif

        @yield('content')
    </main>
</body>

</html>