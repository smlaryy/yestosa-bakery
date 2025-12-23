<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-yestosa-bakery.png') }}">
    <title>@yield('title', 'Yestosa Bakery')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#FAF7F2] text-[#5A1F2A]">
    <header class="border-b bg-white" x-data="{ open: false }">
        <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img
                    src="/images/logo-yestosa-bakery.png"
                    alt="Yestosa Bakery"
                    class="h-10 w-10 object-contain">
                <span class="font-bold text-lg text-[#6B1F2B]">
                    Yestosa Bakery
                </span>
            </a>



            {{-- DESKTOP MENU --}}
            <nav class="hidden md:flex items-center gap-4 text-sm">
                <a href="{{ route('home') }}" class="text-zinc-600 hover:text-zinc-900">
                    Beranda
                </a>

                <a href="{{ route('products.index') }}" class="text-zinc-600 hover:text-zinc-900">
                    Katalog
                </a>

                <a href="{{ route('howto') }}" class="text-zinc-600 hover:text-zinc-900">
                    Cara Pesan
                </a>

                @auth
                @if(auth()->user()?->is_admin)
                <a href="{{ route('admin.dashboard') }}"
                    class="px-3 py-1.5 rounded border hover:bg-zinc-100">
                    Admin
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-xs text-zinc-400 hover:text-zinc-600">
                        Logout
                    </button>
                </form>
                @endif
                @else
                <a href="{{ route('login') }}"
                    class="text-xs text-zinc-400 hover:text-zinc-600">
                    Admin Login
                </a>
                @endauth
            </nav>

            {{-- HAMBURGER (MOBILE ONLY) --}}
            <button @click="open = !open"
                class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded border text-zinc-700">
                ☰
            </button>
        </div>

        {{-- MOBILE MENU --}}
        <div x-show="open"
            x-transition
            @click.outside="open = false"
            class="md:hidden border-t bg-white">

            <div class="px-6 py-4 space-y-3 text-sm">
                <a href="{{ route('home') }}"
                    class="block text-zinc-700">
                    Beranda
                </a>

                <a href="{{ route('products.index') }}"
                    class="block text-zinc-700">
                    Katalog
                </a>

                <a href="{{ route('howto') }}"
                    class="block text-zinc-700">
                    Cara Pesan
                </a>

                <hr>

                @auth
                @if(auth()->user()?->is_admin)
                <a href="{{ route('admin.dashboard') }}"
                    class="block font-medium">
                    Admin Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-left text-zinc-500">
                        Logout
                    </button>
                </form>
                @endif
                @else
                <a href="{{ route('login') }}" class="text-zinc-500">
                    Admin Login
                </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-8">
        @yield('content')
    </main>

    <footer class="border-t bg-white">
        <div class="max-w-6xl mx-auto px-6 py-6 text-sm text-zinc-600">
            © {{ date('Y') }} Yestosa Bakery • Cepu – Padangan
        </div>
    </footer>

    @php
    $wa = preg_replace('/\D+/', '', (string) config('business.wa'));
    $waLink = $wa
    ? "https://wa.me/{$wa}?text=" . urlencode("Halo " . config('business.name') . ", saya mau pesan 😊")
    : null;
    @endphp

    @if($waLink)
    <a href="{{ $waLink }}"
        target="_blank"
        aria-label="Pesan via WhatsApp"
        class="fixed bottom-5 right-5 z-50 flex items-center gap-2 rounded-full
          bg-emerald-500 px-4 py-3 text-white shadow-lg
          hover:bg-emerald-600 transition
          animate-wa-float
          hover:-translate-y-0.5 hover:shadow-xl">
        <span class="text-lg">💬</span>
        <span class="hidden sm:inline text-sm font-semibold">Pesan Sekarang</span>
    </a>

    <style>
        /* animasi halus muncul: fade + naik */
        @keyframes waIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-wa-float {
            animation: waIn 350ms ease-out both;
        }
    </style>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function poClosedAlert() {
            Swal.fire({
                icon: 'warning',
                title: 'Pre-Order Ditutup',
                text: 'Produk ini sedang tidak menerima pesanan saat ini.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#6B1F2B'
            })
        }
    </script>


</body>

</html>