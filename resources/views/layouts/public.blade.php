<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Wira Garden') }}</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: {{ setting('color_primary', '#047857') }};
            --color-accent: {{ setting('color_accent', '#ea580c') }};
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 transition-all duration-300" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-bold group-hover:bg-secondary transition-colors">
                            W
                        </div>
                        <span class="font-heading font-bold text-2xl text-primary tracking-tight">
                            Wira Garden
                        </span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden sm:flex sm:items-center sm:space-x-8">
                    <a href="{{ url('/') }}" class="text-charcoal hover:text-secondary px-3 py-2 font-medium transition-colors">Beranda</a>
                    <a href="{{ route('about') }}" class="text-charcoal hover:text-secondary px-3 py-2 font-medium transition-colors">Tentang Kami</a>
                    <a href="{{ route('destinations.index') }}" class="text-charcoal hover:text-secondary px-3 py-2 font-medium transition-colors">Destinasi</a>
                    <a href="{{ route('facilities.index') }}" class="text-charcoal hover:text-secondary px-3 py-2 font-medium transition-colors">Fasilitas</a>
                    <a href="{{ route('tickets.index') }}" class="text-charcoal hover:text-secondary px-3 py-2 font-medium transition-colors">Harga Tiket</a>
                    <a href="{{ route('galleries.index') }}" class="text-charcoal hover:text-secondary px-3 py-2 font-medium transition-colors">Galeri</a>
                    
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('contact_whatsapp', '6281234567890')) }}" target="_blank" class="text-charcoal hover:text-primary transition-colors flex items-center justify-center p-2 rounded-full hover:bg-primary/5" title="Hubungi Kami">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </a>
                    
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-primary hover:text-green-800 px-3 py-2 font-bold transition-colors">Dashboard Admin</a>
                        @else
                            <a href="{{ route('user.orders.index') }}" class="text-primary hover:text-green-800 px-3 py-2 font-bold transition-colors">Riwayat Reservasi</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700 px-3 py-2 font-medium transition-colors">Keluar</button>
                            </form>
                        @endif
                        <a href="{{ route('reservations.create') }}" class="btn-primary ml-2 !px-6 !py-2 text-sm shadow-md">Reservasi</a>
                    @else
                        <a href="{{ route('login') }}" class="text-charcoal hover:text-primary px-3 py-2 font-medium transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary ml-2 !px-6 !py-2 text-sm shadow-md">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = !open" class="text-charcoal hover:text-primary focus:outline-none p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="open" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" class="sm:hidden bg-white/95 backdrop-blur-md border-t border-gray-100 shadow-xl" x-transition style="display: none;">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="{{ url('/') }}" class="block px-3 py-3 text-base font-medium text-charcoal hover:text-secondary hover:bg-secondary/5 rounded-xl">Beranda</a>
                <a href="{{ route('about') }}" class="block px-3 py-3 text-base font-medium text-charcoal hover:text-secondary hover:bg-secondary/5 rounded-xl">Tentang Kami</a>
                <a href="{{ route('destinations.index') }}" class="block px-3 py-3 text-base font-medium text-charcoal hover:text-secondary hover:bg-secondary/5 rounded-xl">Destinasi</a>
                <a href="{{ route('facilities.index') }}" class="block px-3 py-3 text-base font-medium text-charcoal hover:text-secondary hover:bg-secondary/5 rounded-xl">Fasilitas</a>
                <a href="{{ route('tickets.index') }}" class="block px-3 py-3 text-base font-medium text-charcoal hover:text-secondary hover:bg-secondary/5 rounded-xl">Harga Tiket</a>
                <a href="{{ route('galleries.index') }}" class="block px-3 py-3 text-base font-medium text-charcoal hover:text-secondary hover:bg-secondary/5 rounded-xl">Galeri</a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', setting('contact_whatsapp', '6281234567890')) }}" target="_blank" class="block px-3 py-3 text-base font-medium text-charcoal hover:text-secondary hover:bg-secondary/5 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    Hubungi Kami
                </a>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-3 text-base font-bold text-primary hover:text-green-800 hover:bg-secondary/5 rounded-xl">Dashboard Admin</a>
                    @else
                        <a href="{{ route('user.orders.index') }}" class="block px-3 py-3 text-base font-bold text-primary hover:text-green-800 hover:bg-secondary/5 rounded-xl">Riwayat Reservasi</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-3 text-base font-medium text-red-500 hover:text-red-700 hover:bg-red-50 rounded-xl">Keluar</button>
                        </form>
                    @endif
                    <a href="{{ route('reservations.create') }}" class="block w-full text-center btn-primary mt-4">Reservasi Sekarang</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-3 text-base font-medium text-charcoal hover:text-primary hover:bg-primary/5 rounded-xl">Masuk</a>
                    <a href="{{ route('register') }}" class="block w-full text-center btn-primary mt-4">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white py-16 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div>
                    <h3 class="font-heading text-2xl font-bold mb-4 text-white">Wira Garden</h3>
                    <p class="text-gray-300 leading-relaxed">Destinasi wisata alam keluarga terbaik di Bandar Lampung dengan fasilitas lengkap, aliran sungai jernih, dan suasana asri pegunungan.</p>
                </div>
                <div>
                    <h3 class="font-heading text-xl font-semibold mb-6 text-white">Eksplorasi</h3>
                    <ul class="space-y-3 text-gray-300">
                        <li><a href="{{ url('/') }}" class="hover:text-accent transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-accent"></span> Beranda</a></li>
                        <li><a href="{{ route('destinations.index') }}" class="hover:text-accent transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-accent"></span> Destinasi</a></li>
                        <li><a href="{{ route('galleries.index') }}" class="hover:text-accent transition-colors flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-accent"></span> Galeri</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-heading text-xl font-semibold mb-6 text-white">Kontak Kami</h3>
                    <ul class="space-y-4 text-gray-300">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Wan Abdurrahman, Batu Putuk, Kec. Teluk Betung Utara, Kota Bandar Lampung</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>hello@wiragarden.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-white/10 text-sm text-gray-400 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p>&copy; {{ date('Y') }} Wira Garden. Hak Cipta Dilindungi.</p>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ url('/admin/dashboard') }}" class="text-accent hover:text-white transition-colors font-medium">Dashboard Admin</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors">Login Admin</a>
                @endauth
            </div>
        </div>
    </footer>
</body>
</html>
