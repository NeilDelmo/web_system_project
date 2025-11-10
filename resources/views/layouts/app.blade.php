<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
</head>
<body>
    <header style="padding: 1rem; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 12px;">
        <img src="{{ asset('images/cuevaslogo.png') }}" alt="Cuevas Bakery Logo" height="40">
        <span style="font-size: 1.5rem; font-weight: 600; color: #b71c1c;">{{ config('app.name', 'Cuevas Bakery') }}</span>
    </header>

    <main style="padding: 1rem;">
        @yield('content')
    </main>
</body>
</html>