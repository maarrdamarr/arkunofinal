<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Royal Auction House') }}</title>
        <!-- Inline SVG favicon (dark green tile with 'A') -->
        <link rel="icon" href="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%230f5132'/><text x='50' y='65' font-size='55' text-anchor='middle' fill='%23ffffff' font-family='Arial' font-weight='700'>A</text></svg>">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .font-serif-display { font-family: 'Cinzel', serif; }
            .font-sans-body { font-family: 'Lato', sans-serif; }
            .moving-bg { animation: moveBackground 35s ease-in-out infinite alternate; }
            @keyframes moveBackground { 0% { transform: scale(1.0) translate(0,0); } 50% { transform: scale(1.08) translate(-1%, -0.5%); } 100% { transform: scale(1.0) translate(0,0); } }
        </style>
    </head>
    <body class="font-sans-body text-gray-900 antialiased">

        <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

            <!-- LEFT: Form area -->
            <div class="flex items-center justify-center p-8 lg:p-16 bg-white">
                <div class="w-full max-w-md">
                    {{ $slot }}
                    <div class="mt-8 text-center text-sm text-gray-400 tracking-widest font-serif-display">&copy; {{ date('Y') }} {{ config('app.name', 'Royal Auction House') }}</div>
                </div>
            </div>

            <!-- RIGHT: Image area (hidden on small screens) -->
            <div class="hidden lg:block relative overflow-hidden">
                <img src="{{ asset('images/login/forest.jpg') }}" alt="Forest"
                     onerror="this.onerror=null;this.src='https://source.unsplash.com/1600x900/?forest';"
                     class="absolute inset-0 w-full h-full object-cover moving-bg">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/40 via-emerald-800/30 to-transparent"></div>
                <div class="relative z-10 h-full flex items-center justify-center">
                    <div class="text-white text-center max-w-sm px-8">
                        <h2 class="text-3xl font-serif-display font-bold mb-3">ARTKUNO</h2>
                        <p class="text-sm opacity-90">menghubungkan masa lalu dengan masa depan</p>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
