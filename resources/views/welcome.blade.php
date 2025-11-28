<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lelang Antik - Premium Auction</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=montserrat:400,600,700,800|open-sans:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Gaya Muvid biasanya menggunakan Font Sans-Serif yang tegas */
        .font-heading { font-family: 'Montserrat', sans-serif; }
        .font-body { font-family: 'Open Sans', sans-serif; }
        
        /* Warna Khas Dark Theme Muvid */
        .bg-muvid-dark { background-color: #0b0c2a; }
        .bg-muvid-card { background-color: #1a1c4b; }
        .text-muvid-accent { color: #e50914; /* Merah Netflix/Muvid */ }
        .bg-muvid-accent { background-color: #e50914; }
        .border-muvid-accent { border-color: #e50914; }
    </style>
</head>
<body class="font-body bg-muvid-dark text-gray-200 antialiased selection:bg-red-500 selection:text-white">

    <nav class="fixed w-full z-50 top-0 start-0 border-b border-gray-800 bg-muvid-dark/90 backdrop-blur-md transition-all duration-300">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="/" class="flex items-center space-x-2 rtl:space-x-reverse group">
                <i class="fas fa-gavel text-2xl text-red-600 group-hover:rotate-12 transition"></i>
                <span class="self-center text-2xl font-heading font-extrabold whitespace-nowrap text-white">LELANG<span class="text-red-600">ANTIK</span></span>
            </a>
            
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white hover:text-red-500 font-bold transition text-sm uppercase tracking-wider">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-red-500 font-bold transition text-sm uppercase tracking-wider hidden sm:block">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-900 font-medium rounded-full text-sm px-6 py-2 text-center transition shadow-lg shadow-red-600/30">
                                    Join Now
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <section class="relative h-screen min-h-[600px] flex items-center justify-start overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1459745930869-b3d0d72c3cbb?q=80&w=1920&auto=format&fit=crop" 
                 alt="Hero Background" 
                 class="w-full h-full object-cover object-center opacity-40 scale-105 animate-[pulse_10s_infinite]">
            <div class="absolute inset-0 bg-gradient-to-r from-[#0b0c2a] via-[#0b0c2a]/80 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#0b0c2a] via-transparent to-transparent"></div>
        </div>

        <div class="relative z-10 px-4 max-w-screen-xl mx-auto w-full pt-20">
            <div class="max-w-2xl">
                <span class="inline-block py-1 px-3 rounded bg-red-600/20 border border-red-600 text-red-500 text-xs font-bold tracking-widest uppercase mb-4">
                    Exclusive Auction
                </span>
                <h1 class="mb-6 text-5xl md:text-7xl font-heading font-extrabold text-white leading-tight">
                    History in <br> Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-purple-600">Hands</span>
                </h1>
                <p class="mb-8 text-lg text-gray-400 leading-relaxed">
                    Temukan koleksi barang antik paling langka, mulai dari jam kuno, keramik dinasti, hingga lukisan bersejarah. Tawar sekarang sebelum hilang selamanya.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#items" class="inline-flex justify-center items-center py-4 px-8 text-base font-bold text-white rounded-full bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-900 transition shadow-lg shadow-red-600/40">
                        <i class="fas fa-play mr-2 text-xs"></i> Mulai Menawar
                    </a>
                    <a href="#news" class="inline-flex justify-center items-center py-4 px-8 text-base font-bold text-white rounded-full border border-gray-600 hover:bg-white/10 transition">
                        Baca Jurnal
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="items" class="py-20 relative">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex justify-between items-end mb-10 border-b border-gray-800 pb-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-heading font-bold text-white">Live <span class="text-red-600">Auctions</span></h2>
                    <p class="mt-2 text-gray-500 text-sm uppercase tracking-widest">Sedang berlangsung</p>
                </div>
                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-400 hover:text-white transition flex items-center gap-2">
                    VIEW ALL <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($items as $item)
                <div class="group relative bg-muvid-card rounded-xl overflow-hidden shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-red-900/20">
                    <div class="relative aspect-[2/3] overflow-hidden">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110 group-hover:opacity-75">
                        @else
                            <img src="https://images.unsplash.com/photo-1599691652197-76790937a092?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover transition duration-500 group-hover:scale-110 group-hover:opacity-75">
                        @endif
                        
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 z-10">
                            <a href="{{ route('login') }}" class="bg-red-600 text-white rounded-full p-4 shadow-lg transform scale-0 group-hover:scale-100 transition duration-300 hover:bg-red-700">
                                <i class="fas fa-gavel text-xl"></i>
                            </a>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0b0c2a] to-transparent opacity-80"></div>
                        
                        <div class="absolute top-3 right-3 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow-md">
                            OPEN
                        </div>
                    </div>

                    <div class="p-4 absolute bottom-0 w-full">
                        <h3 class="text-lg font-heading font-bold text-white mb-1 truncate group-hover:text-red-500 transition">{{ $item->name }}</h3>
                        <div class="flex justify-between items-center text-sm text-gray-400">
                            <span>Start Price:</span>
                            <span class="text-white font-bold">Rp {{ number_format($item->start_price) }}</span>
                        </div>
                    </div>
                </div>
                @empty
                @for($i=0; $i<4; $i++)
                <div class="group relative bg-muvid-card rounded-xl overflow-hidden opacity-50">
                    <div class="aspect-[2/3] bg-gray-800 flex items-center justify-center">
                        <i class="fas fa-box-open text-4xl text-gray-600"></i>
                    </div>
                </div>
                @endfor
                @endforelse
            </div>
        </div>
    </section>

    <section id="news" class="py-20 bg-[#0f1035]">
        <div class="max-w-screen-xl mx-auto px-4">
             <div class="flex justify-between items-end mb-10 border-b border-gray-800 pb-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-heading font-bold text-white">Latest <span class="text-blue-500">News</span></h2>
                    <p class="mt-2 text-gray-500 text-sm uppercase tracking-widest">Berita & Edukasi</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($news as $article)
                <div class="bg-muvid-card rounded-xl overflow-hidden shadow-lg group hover:shadow-blue-900/20 transition">
                    <div class="relative h-48 overflow-hidden">
                        @if($article->image)
                             <img src="{{ asset('storage/' . $article->image) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                        @else
                             <img src="https://images.unsplash.com/photo-1505664194779-8beaceb93744?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                        @endif
                        <div class="absolute top-0 left-0 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-br-lg">
                            NEWS
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                            <i class="far fa-calendar-alt"></i> {{ $article->created_at->format('d M Y') }}
                        </div>
                        <h3 class="text-xl font-heading font-bold text-white mb-3 leading-snug group-hover:text-blue-500 transition">
                            {{ $article->title }}
                        </h3>
                        <p class="text-gray-400 text-sm line-clamp-2">
                            {{ Str::limit($article->content, 100) }}
                        </p>
                        <a href="#" class="inline-block mt-4 text-sm font-bold text-blue-500 hover:text-blue-400">
                            Read More <i class="fas fa-angle-right ml-1"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="bg-[#050614] text-white py-16 border-t border-gray-900">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-8 md:mb-0">
                    <span class="text-2xl font-heading font-extrabold text-white">LELANG<span class="text-red-600">ANTIK</span></span>
                    <p class="text-gray-500 text-sm mt-2 max-w-xs">
                        The world's premier marketplace for rare antiques and collectibles.
                    </p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white text-xl transition"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white text-xl transition"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white text-xl transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white text-xl transition"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="border-t border-gray-900 mt-10 pt-8 text-center text-gray-600 text-sm">
                &copy; 2025 Lelang Antik. Designed with <i class="fas fa-heart text-red-600"></i> by Laragon/Laravel.
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    @include('components.live-chat-widget')

</body>
</html>