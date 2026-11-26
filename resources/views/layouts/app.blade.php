<!doctype html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Harwinder Singh – Web Developer | Full Stack Portfolio')</title>
    <meta name="description" content="Portfolio of Harwinder Singh, a Web Developer building responsive full-stack applications with PHP, Laravel, MySQL, and JavaScript." />
    <meta name="theme-color" content="#000000" />
    @include('partials.assets')
</head>
<body class="bg-black text-white antialiased selection:bg-white/20 selection:text-white">
    @yield('content')

    {{-- Motion layer runs after the sections exist in the page --}}
    @include('partials.motion')
</body>
</html>