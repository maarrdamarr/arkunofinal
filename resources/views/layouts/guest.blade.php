<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>ARTKUNO | Seni Adalah Ledakan</title>
        <!-- Inline SVG favicon (dark green tile with 'A') -->
        <link rel="icon" href="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' fill='%230f5132'/><text x='50' y='65' font-size='55' text-anchor='middle' fill='%23ffffff' font-family='Arial' font-weight='700'>A</text></svg>">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .font-serif-display { font-family: 'Cinzel', serif; }
            .font-sans-body { font-family: 'Lato', sans-serif; }

            /* Animasi Background Bergerak (Ken Burns Effect) */
            @keyframes moveBackground {
                0% { transform: scale(1.0) translate(0, 0); }
                50% { transform: scale(1.15) translate(-2%, -1%); }
                100% { transform: scale(1.0) translate(0, 0); }
            }

            .moving-bg {
                animation: moveBackground 35s ease-in-out infinite alternate;
            }
        </style>
    </head>
    <body class="font-sans-body text-gray-900 antialiased overflow-hidden">
        
        <div class="fixed inset-0 -z-20 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=2070&auto=format&fit=crop" 
                 class="absolute w-full h-full object-cover moving-bg"
                 alt="Luxury Background">
        </div>

        <div class="fixed inset-0 -z-10 bg-emerald-950/70 backdrop-blur-[3px]"></div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            
            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/95 backdrop-blur-xl shadow-2xl border border-yellow-500/30 rounded-3xl relative overflow-hidden transform transition-all hover:scale-[1.01] duration-500">
                
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-yellow-600 via-yellow-300 to-yellow-600"></div>
                
                <div class="absolute -bottom-10 -right-10 text-emerald-900/5 rotate-12 pointer-events-none">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.633 1.24l-1.745 5.51a1 1 0 01-1.91 0l-1.745-5.51a1 1 0 01-.633-1.24A3.989 3.989 0 013 15a3.989 3.989 0 012.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L14.164 4.323V3a1 1 0 011-1h-5z" clip-rule="evenodd" /></svg>
                </div>

                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>
            
            <div class="mt-8 text-white/40 text-xs tracking-widest uppercase font-serif-display">
                &copy; 2025 Royal Auction House
            </div>
        </div>
    </body>
</html>