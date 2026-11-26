<!doctype html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login</title>
    @include('partials.assets')
</head>
<body class="site-body admin-theme flex min-h-screen items-center justify-center bg-black p-6 text-white">
    <canvas id="bg-canvas" aria-hidden="true"></canvas>
    <div class="grain-overlay" aria-hidden="true"></div>
    <div class="relative z-0 w-full max-w-md rounded-2xl border border-white/10 bg-[#0A0A0A]/90 p-8 shadow-[0_30px_100px_rgba(0,0,0,0.65)] backdrop-blur-xl">
        <h1 class="mb-1 font-display text-2xl font-bold">Admin Login</h1>
        <p class="mb-6 text-sm text-[#A3A3A3]">Sign in to manage your portfolio content.</p>

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-white/15 bg-black px-4 py-3 text-white focus:border-white focus:outline-none" />
                @error('email') <p class="mt-1.5 text-xs text-[#D4D4D4]">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password" class="mb-2 block text-sm">Password</label>
                <input id="password" name="password" type="password" required class="w-full rounded-lg border border-white/15 bg-black px-4 py-3 text-white focus:border-white focus:outline-none" />
            </div>
            <label class="flex items-center gap-2 text-sm text-[#A3A3A3]">
                <input type="checkbox" name="remember" class="rounded" /> Remember me
            </label>
            <button type="submit" class="w-full rounded-lg bg-white px-5 py-3 font-medium text-black shadow-[0_0_24px_rgba(255,255,255,0.12)] transition hover:bg-[#E5E5E5] hover:shadow-[0_0_32px_rgba(255,255,255,0.2)]">Log in</button>
        </form>
    </div>
</body>
</html>
