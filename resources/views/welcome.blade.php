<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artkuno | seni adalah ledakan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;800&family=Lato:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* --- Typography --- */
        .font-serif-display { font-family: 'Cinzel', serif; }
        .font-sans-body { font-family: 'Lato', sans-serif; }

        /* --- Color Variables --- */
        :root {
            --royal-green: #042f2e; /* Teal-950 */
            --royal-gold: #d4af37;
            --cream-bg: #fdfbf7;
        }

        /* --- Custom Utilities --- */
        .text-gold-gradient {
            background: linear-gradient(135deg, #bf953f, #fcf6ba, #b38728, #fbf5b7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 300%;
            animation: shimmer 5s infinite linear;
        }

        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        /* --- Glassmorphism Navbar --- */
        .nav-scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }
        .nav-scrolled .nav-link { color: #1f2937 !important; }
        .nav-scrolled .logo-text { color: #042f2e !important; }

        /* --- Card Hover Effects --- */
        .auction-card {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .auction-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.1);
        }
        .auction-card img {
            transition: transform 0.8s ease;
        }
        .auction-card:hover img {
            transform: scale(1.08);
        }

        /* --- Button Effects --- */
        .btn-gold {
            background: linear-gradient(to right, #d97706, #b45309);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 0%; height: 100%;
            background: #042f2e;
            transition: all 0.4s ease;
            z-index: -1;
        }
        .btn-gold:hover::before { width: 100%; }
    </style>
</head>
<body class="font-sans-body bg-stone-50 text-gray-800 antialiased overflow-x-hidden selection:bg-yellow-500 selection:text-white">

    <nav id="navbar" class="fixed w-full z-50 transition-all duration-500 py-6">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center">
                
                <a href="/" class="flex items-center gap-3 group">
                    <div class="logo-text font-serif-display font-bold text-2xl text-white tracking-widest transition-colors">
                        ART<span class="text-yellow-500">KUNO</span>
                    </div>
                </a>

                <div class="hidden md:flex space-x-12 items-center">
                    <a href="#home" class="nav-link text-white/90 hover:text-yellow-400 font-medium text-xs uppercase tracking-[0.2em] transition">Home</a>
                    <a href="#collection" class="nav-link text-white/90 hover:text-yellow-400 font-medium text-xs uppercase tracking-[0.2em] transition">Collection</a>
                    <a href="#about" class="nav-link text-white/90 hover:text-yellow-400 font-medium text-xs uppercase tracking-[0.2em] transition">About</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-white text-emerald-950 rounded-full font-bold text-xs uppercase tracking-wider hover:bg-yellow-400 transition shadow-lg">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link text-white font-bold text-xs uppercase tracking-wider hidden sm:block hover:text-yellow-400 transition">Log In</a>
                        <a href="{{ route('register') }}" class="px-6 py-2 border border-yellow-500 text-yellow-400 rounded-full font-bold text-xs uppercase tracking-wider hover:bg-yellow-500 hover:text-emerald-900 transition">
                            Join
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1618220179428-22790b461013?q=80&w=2000&auto=format&fit=crop" 
                class="w-full h-full object-cover animate-pulse-slow" 
                style="animation-duration: 20s;"
                alt="Luxury Interior">
            <div class="absolute inset-0 bg-gradient-to-b from-emerald-950/90 via-emerald-900/60 to-stone-50"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl px-6 pt-20">
            <div data-aos="fade-down" data-aos-duration="1000">
            </div>
            <h1 class="font-serif-display text-5xl md:text-7xl lg:text-8xl font-medium text-white mb-8 leading-tight" 
                data-aos="fade-up" data-aos-duration="1200">
                The Art of <br>
                <span class="text-gold-gradient font-bold">Timeless Luxury</span>
            </h1>
            
            <p class="text-gray-200 text-lg font-light mb-12 max-w-2xl mx-auto leading-relaxed" 
               data-aos="fade-up" data-aos-delay="200" data-aos-duration="1200">
            a leading online auction platform specializing in antiques and fine art. Our mission is to connect collectors, sellers, and art enthusiasts around the world through a unique auction experience
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-5" 
                 data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                <a href="#collection" class="btn-gold px-8 py-4 text-white rounded-full font-bold text-sm uppercase tracking-widest shadow-xl shadow-yellow-900/20 transition-all transform hover:-translate-y-1">
                    Mulai Menawar
                </a>
                <a href="#about" class="px-8 py-4 bg-transparent border border-white/30 text-white rounded-full font-bold text-sm uppercase tracking-widest hover:bg-white hover:text-emerald-900 transition-all backdrop-blur-sm">
                    Pelajari Kami
                </a>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
            <i class="fas fa-chevron-down text-white/50 text-xl"></i>
        </div>
    </section>

<section id="about" class="py-24 bg-[#f9f8f4] border-b border-gray-200 overflow-hidden">
        <div class="container mx-auto px-6 md:px-12 max-w-4xl text-center">
            
            <div data-aos="fade-down" data-aos-duration="1000">
                <h1 class="font-serif-display text-5xl md:text-7xl lg:text-8xl font-medium text-dark-gradient mb-8 leading-tight" 
                    data-aos="fade-up" data-aos-duration="1200">
                    "ArtKuno"
                    <h1>
                        <span class="text-primary-gradient font-bold font-serif-display text-lg md:text-xl">Timeless Luxury</span><br>
                    </h1>
                    <br>
                </h1>
            </div>

            <div data-aos="fade-up" data-aos-duration="1200" data-aos-delay="200">
                <p class="font-body text-gold-gradient text-xllg md:text-xl text-gray-600 leading-relaxed italic">
                    "Menghubungkan masa lalu dengan masa depan melalui seni."
                </p>
                
                <p class="font-body text-base md:text-lg text-gray-700 leading-loose mt-6 text-justify md:text-center">
                    <span class="font-semibold text-gray-900">Artkuno</span> adalah platform lelang online terkemuka yang mengkhususkan diri dalam 
                    <strong>barang antik</strong> dan <strong>seni rupa</strong>. Misi kami adalah menghubungkan kolektor, penjual, 
                    dan penggemar seni di seluruh dunia melalui pengalaman lelang yang <span class="border-b-2 border-[#b8860b]/30">aman, transparan, dan mudah diakses</span>. 
                </p>

                <p class="font-body text-base md:text-lg text-gray-700 leading-loose mt-4 text-justify md:text-center">
                    Dengan kurasi ketat dan jaringan global, kami memastikan setiap item yang ditawarkan memiliki 
                    nilai sejarah dan estetika yang tinggi.
                </p>
            </br>
                <p> 
                    <h1>
                        <span class="text-dark font-bold font-serif-display text-lg md:text-xl">Timeless Luxury</span><br>
                    </h1> 
                <br>      
                </br>                                                                                                                              
                </p>
            </div>
        </div>
    </section>

    <section class="py-12 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-100">
                <div data-aos="fade-up" data-aos-delay="0">
                    <p class="font-serif-display text-3xl font-bold text-emerald-900">1.2K+</p>
                    <p class="text-gray-400 text-xs uppercase tracking-widest mt-1">Artefak Terjual</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="100">
                    <p class="font-serif-display text-3xl font-bold text-emerald-900">Rp 50M+</p>
                    <p class="text-gray-400 text-xs uppercase tracking-widest mt-1">Total Transaksi</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="200">
                    <p class="font-serif-display text-3xl font-bold text-emerald-900">100%</p>
                    <p class="text-gray-400 text-xs uppercase tracking-widest mt-1">Terverifikasi</p>
                </div>
                <div data-aos="fade-up" data-aos-delay="300">
                    <p class="font-serif-display text-3xl font-bold text-emerald-900">24/7</p>
                    <p class="text-gray-400 text-xs uppercase tracking-widest mt-1">Premium Support</p>
                </div>
            </div>
        </div>
    </section>

    <section id="collection" class="py-24 bg-stone-50 relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-yellow-600 font-bold uppercase tracking-[0.2em] text-xs">Sedang Berlangsung</span>
                <h2 class="font-serif-display text-4xl font-normal text-emerald-950 mt-3">Koleksi Terkurasi</h2>
                <div class="w-24 h-1 bg-yellow-500 mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($auctions as $index => $item)
                <div class="auction-card bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-2xl group flex flex-col h-full border border-stone-100" 
                     data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    
                    <div class="relative aspect-[4/5] overflow-hidden bg-gray-100">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://source.unsplash.com/random/400x500/?antique,art,sculpture" class="w-full h-full object-cover">
                        @endif
                        
                        <div class="absolute top-4 left-4 flex gap-2">
                            <span class="bg-white/90 backdrop-blur text-emerald-900 text-[10px] font-bold px-3 py-1 rounded-sm uppercase tracking-wider">
                                Lot #{{ $item->id }}
                            </span>
                            <span class="bg-red-600 text-white text-[10px] font-bold px-3 py-1 rounded-sm uppercase tracking-wider animate-pulse">
                                Live
                            </span>
                        </div>

                        <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-emerald-950 via-emerald-950/80 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                             <p class="text-yellow-400 text-[10px] uppercase font-bold tracking-widest mb-1">Current Bid</p>
                             <p class="text-white font-serif-display text-xl">Rp {{ number_format($item->start_price) }}</p>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center gap-3 mb-4">
                            @if($item->user->avatar)
                                <img src="{{ asset('storage/' . $item->user->avatar) }}" class="w-8 h-8 rounded-full border border-gray-100 object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=E5E7EB&color=374151" class="w-8 h-8 rounded-full border border-gray-100">
                            @endif
                            <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold">{{ $item->user->name }}</span>
                        </div>

                        <h3 class="font-serif-display text-xl text-gray-900 mb-3 leading-snug group-hover:text-yellow-600 transition-colors">
                            <a href="{{ route('bidder.auction.show', $item->id) }}" class="line-clamp-2">{{ $item->name }}</a>
                        </h3>
                        
                        <p class="text-gray-500 text-sm font-light line-clamp-2 mb-6 flex-grow leading-relaxed">{{ $item->description }}</p>

                        <a href="{{ route('bidder.auction.show', $item->id) }}" class="w-full block text-center py-3 border border-emerald-900 text-emerald-900 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-900 hover:text-white transition-all duration-300">
                            Detail Lelang
                        </a>
                    </div>
                </div>
                @empty
                    <div class="col-span-full py-24 text-center">
                        <div class="inline-block p-6 rounded-full bg-stone-100 mb-4">
                            <i class="fas fa-landmark text-stone-300 text-4xl"></i>
                        </div>
                        <h3 class="font-serif-display text-xl text-gray-500">Belum ada koleksi yang dibuka.</h3>
                        <p class="text-gray-400 mt-2">Silakan kembali lagi nanti untuk penawaran eksklusif.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-16 text-center">
                <a href="#" class="inline-flex items-center gap-2 text-emerald-900 font-bold text-xs uppercase tracking-[0.2em] border-b border-emerald-900 pb-1 hover:text-yellow-600 hover:border-yellow-600 transition-colors">
                    Lihat Katalog Lengkap <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <section id="news" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-yellow-600 font-bold uppercase tracking-[0.2em] text-xs">Wawasan & Berita</span>
                <h2 class="font-serif-display text-4xl font-normal text-emerald-950 mt-3">Kabar Terbaru ARTKUNO</h2>
                <div class="w-24 h-1 bg-yellow-500 mx-auto mt-6 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($news as $index => $newsItem)
                <div class="auction-card bg-stone-50 rounded-xl overflow-hidden shadow-sm hover:shadow-2xl group flex flex-col h-full border border-stone-100"
                     data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                    <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
                        @if($newsItem->image)
                            <img src="{{ asset('storage/' . $newsItem->image) }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://source.unsplash.com/random/800x600/?news,article,vintage" class="w-full h-full object-cover">
                        @endif
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-3">{{ $newsItem->created_at->format('d F Y') }}</span>

                        <h3 class="font-serif-display text-xl text-gray-900 mb-4 leading-snug group-hover:text-yellow-600 transition-colors">
                            <a href="{{ route('news.show', $newsItem) }}" class="line-clamp-2">{{ $newsItem->title }}</a>
                        </h3>

                        <p class="text-gray-500 text-sm font-light line-clamp-3 mb-6 flex-grow leading-relaxed">{{ $newsItem->content }}</p>

                        <a href="{{ route('news.show', $newsItem) }}" class="w-full block text-center py-3 border border-emerald-900 text-emerald-900 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-emerald-900 hover:text-white transition-all duration-300">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
                @empty
                    <div class="col-span-full py-24 text-center">
                        <div class="inline-block p-6 rounded-full bg-stone-100 mb-4">
                            <i class="fas fa-newspaper text-stone-300 text-4xl"></i>
                        </div>
                        <h3 class="font-serif-display text-xl text-gray-500">Belum ada berita yang dipublikasikan.</h3>
                        <p class="text-gray-400 mt-2">Nantikan pembaruan dan wawasan dari kami.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-24 bg-emerald-950 relative overflow-hidden flex items-center">
        <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-600/20 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-[100px]"></div>
        
        <div class="max-w-5xl mx-auto px-6 text-center relative z-10">
            <h2 class="font-serif-display text-4xl md:text-5xl text-white mb-6 leading-tight" data-aos="fade-up">
                Memiliki Barang Antik Berharga?
            </h2>
            <p class="text-gray-300 text-lg font-light mb-10 max-w-2xl mx-auto leading-relaxed" data-aos="fade-up" data-aos-delay="100">
                Jual koleksi Anda kepada jaringan pembeli elit kami. Kami menjamin proses penilaian yang transparan dan harga terbaik untuk aset sejarah Anda.
            </p>
            <div data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('register') }}" class="btn-gold px-10 py-4 text-white rounded-full font-bold text-sm uppercase tracking-widest inline-block shadow-lg hover:shadow-yellow-500/20 transition-transform hover:-translate-y-1">
                    Daftarkan Barang Anda
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-white pt-20 pb-10 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-16">
                <div class="md:col-span-5" data-aos="fade-right">
                    <a href="/" class="flex items-center gap-2 mb-6">
                        <i class="fas fa-gavel text-yellow-500 text-xl"></i>
                        <span class="font-serif-display font-bold text-2xl text-emerald-950 tracking-widest">ART<span class="text-yellow-500">KUNO</span></span>
                    </a>
                    <p class="text-gray-500 leading-relaxed font-light pr-8">
                        Royal Auction House adalah destinasi utama untuk lelang barang antik dan seni rupa. Kami menghubungkan masa lalu dengan masa depan melalui kepercayaan dan integritas.
                    </p>
                </div>

                <div class="md:col-span-3" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="font-serif-display text-emerald-950 font-bold mb-6">Explore</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-yellow-600 transition">Koleksi Terbaru</a></li>
                        <li><a href="#" class="hover:text-yellow-600 transition">Cara Menawar</a></li>
                        <li><a href="#" class="hover:text-yellow-600 transition">Panduan Penjual</a></li>
                        <li><a href="#" class="hover:text-yellow-600 transition">Tentang Kami</a></li>
                    </ul>
                </div>

                <div class="md:col-span-4" data-aos="fade-left" data-aos-delay="200">
                    <h4 class="font-serif-display text-emerald-950 font-bold mb-6">Concierge</h4>
                    <ul class="space-y-4 text-sm text-gray-500">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-yellow-500 mt-1"></i>
                            <span>the artkuno tower
                            </span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-yellow-500"></i>
                            <span>+62 21 5790 1234</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-yellow-500"></i>
                            <span>artkuno@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-400">
                <p>&copy; 2025 ARTKUNO Indonesia. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-emerald-900 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-emerald-900 transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Init AOS (Animate On Scroll)
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
            easing: 'ease-out-cubic',
        });

        // Navbar Transition Script
        const navbar = document.getElementById('navbar');
        const navLinks = document.querySelectorAll('.nav-link');
        const logoText = document.querySelector('.logo-text');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                // Saat scroll ke bawah (Putih Glassmorphism)
                navbar.classList.add('nav-scrolled');
                navLinks.forEach(link => {
                    link.classList.remove('text-white', 'text-white/90');
                    link.classList.add('text-gray-800');
                });
                logoText.classList.remove('text-white');
                logoText.classList.add('text-emerald-950');
            } else {
                // Saat di paling atas (Transparan)
                navbar.classList.remove('nav-scrolled');
                navLinks.forEach(link => {
                    link.classList.add('text-white/90');
                    link.classList.remove('text-gray-800');
                });
                logoText.classList.add('text-white');
                logoText.classList.remove('text-emerald-950');
            }
        });
    </script>
    
    @include('components.live-chat-widget')

</body>
</html>