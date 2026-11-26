<!doctype html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin') · Portfolio Admin</title>
    @include('partials.assets')
</head>
<body class="site-body admin-theme min-h-screen bg-black text-white antialiased">
    <canvas id="bg-canvas" aria-hidden="true"></canvas>
    <div class="grain-overlay" aria-hidden="true"></div>
    <div class="relative z-0 flex min-h-screen">
        <aside class="hidden w-64 shrink-0 flex-col gap-1 border-r border-white/10 bg-[#0A0A0A]/80 p-5 backdrop-blur-xl md:flex">
            <a href="{{ route('admin.dashboard') }}" class="mb-6 font-display text-lg font-semibold text-white">Portfolio Admin</a>

            <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2 text-sm text-[#A3A3A3] transition hover:bg-white/5 hover:text-white">Dashboard</a>
            @foreach (config('admin.resources') as $key => $definition)
                <a href="{{ route('admin.resource.index', $key) }}" class="rounded-lg px-3 py-2 text-sm text-[#A3A3A3] transition hover:bg-white/5 hover:text-white">{{ $definition['title'] }}</a>
            @endforeach

            <a href="{{ route('home') }}" target="_blank" class="mt-auto rounded-lg px-3 py-2 text-sm text-white transition hover:bg-white/5">View public site ↗</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm text-[#A3A3A3] transition hover:bg-white/5 hover:text-white">Log out</button>
            </form>
        </aside>

        <main class="min-w-0 flex-1 p-6 md:p-10">
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-emerald-400/40 bg-emerald-400/10 p-4 text-sm text-emerald-200">{{ session('status') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>