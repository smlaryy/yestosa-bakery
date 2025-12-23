@extends('layouts.guest')

@section('content')
<div class="text-center mb-6">
    <img src="{{ asset('images/logo-yestosa-bakery.png') }}" class="mx-auto h-16 mb-3" alt="Yestosa Bakery">
    <h2 class="text-2xl font-bold text-[#6B1F2B]">Admin Login</h2>
    <p class="text-sm text-zinc-500">Yestosa Bakery Dashboard</p>
</div>

<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" required autofocus
            class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-[#E8D2C9]">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" required
            class="w-full rounded-lg border px-3 py-2 focus:ring-2 focus:ring-[#E8D2C9]">
    </div>

    <button
        class="w-full bg-[#6B1F2B] text-white py-2 rounded-lg font-semibold hover:bg-[#5a1924] transition">
        Masuk
    </button>
</form>
@endsection
