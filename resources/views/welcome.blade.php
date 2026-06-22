@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gray-900 overflow-hidden min-h-[90vh] flex items-center">
    <div class="absolute inset-0">
        <img class="w-full h-full object-cover opacity-90" src="{{ asset('images/gambar-wira-garden.png') }}" alt="Wira Garden Nature">
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/40 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-primary/10 to-transparent"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-10 z-10 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        <!-- Left Side: Text Content -->
        <div class="max-w-2xl">
            <span class="inline-block py-1.5 px-4 rounded-full bg-white/20 text-white font-bold text-sm tracking-widest mb-6 border border-white/30 backdrop-blur-md shadow-sm">🌿 DESTINASI WISATA ALAM</span>
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-4 leading-tight drop-shadow-lg font-heading">
                Kembali ke <br/>
                <span class="text-accent inline-block mt-2 transform -rotate-2 drop-shadow-2xl" style="font-family: 'Caveat', cursive; font-size: 1.1em;">Harmoni Alam</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-100 mb-10 leading-relaxed font-light drop-shadow">
                Lepaskan penat dan rasakan kesejukan alam. Wira Garden menawarkan pengalaman liburan keluarga tak terlupakan dengan aliran sungai alami yang jernih.
            </p>
            <div class="flex flex-col sm:flex-row gap-5">
                <a href="{{ route('reservations.create') }}" class="bg-accent hover:bg-orange-500 text-white text-center font-bold text-lg px-8 py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
                    Reservasi Sekarang
                </a>
                <a href="{{ route('destinations.index') }}" class="bg-white/10 backdrop-blur-sm border border-white/50 text-white text-center font-bold text-lg px-8 py-4 rounded-xl transition-all duration-300 hover:bg-white hover:text-primary">
                    Jelajahi Fasilitas
                </a>
            </div>
        </div>

        <!-- Right Side: Floating Image & CTA -->
        <div class="hidden lg:flex justify-center items-center relative h-[550px]">
            <!-- Decorative Glow -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-accent/20 rounded-full blur-[80px] z-0"></div>
            
            <!-- Main Glass Card -->
            <div class="relative z-20 w-[500px] bg-white/10 backdrop-blur-xl border border-white/20 rounded-[2.5rem] p-4 shadow-2xl transform hover:-translate-y-2 transition-transform duration-500">
                <!-- Image Container -->
                <div class="w-full h-[320px] rounded-[2rem] overflow-hidden relative shadow-lg group">
                    <img src="{{ asset(setting('hero_image', 'images/gambar-keluarga.png')) }}" alt="Keluarga Wisata Alam" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                </div>
                
                <!-- Content Area -->
                <div class="p-6 pb-2 text-center">
                    <h3 class="font-bold text-4xl text-white mb-2 drop-shadow-sm" style="font-family: 'Caveat', cursive;">{{ setting('hero_title', 'Wisata Alam Keluarga') }}</h3>
                    <p class="text-gray-200 text-base leading-relaxed font-light">{{ setting('hero_subtitle', 'Ciptakan momen tak terlupakan di alam bebas.') }}</p>
                </div>

                <!-- Floating Badge -->
                <div class="absolute -top-5 -right-5 bg-white/95 backdrop-blur-sm px-5 py-3 rounded-2xl shadow-xl z-30 flex items-center justify-center transform rotate-6 animate-[pulse_4s_ease-in-out_infinite]">
                    <div class="text-charcoal font-bold text-center flex items-center gap-2">
                        <span class="text-2xl">🌿</span>
                        <span class="text-sm tracking-wide">Alam Bebas</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Wave Transition -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-10" style="transform: translateY(1px);">
        <svg class="relative block w-full h-[30px] sm:h-[50px] lg:h-[70px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,112.56,189.92,98.33,232.4,88.16,275.67,73.1,321.39,56.44Z" fill="#f9fafb"></path>
        </svg>
    </div>
</div>

<!-- Highlight Section -->
<div class="py-24 bg-background relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-accent font-semibold tracking-widest uppercase mb-3">Pilihan Tiket</h2>
            <h3 class="text-4xl font-bold text-primary font-heading">Akses Tak Terbatas ke Alam</h3>
            <div class="w-24 h-1.5 bg-accent mx-auto mt-6 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($ticketTypes as $ticket)
            <div class="glass-card p-8 group hover:-translate-y-3 transition-all duration-300 relative overflow-hidden bg-white border border-gray-100">
                <div class="absolute top-0 right-0 w-32 h-32 bg-secondary/5 rounded-bl-[100px] -z-10 group-hover:scale-110 transition-transform duration-500"></div>
                
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mb-8 group-hover:bg-primary group-hover:text-white transition-colors duration-300 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
                
                <h4 class="text-2xl font-bold text-primary mb-3 font-heading">{{ $ticket->name }}</h4>
                <p class="text-gray-500 mb-8 min-h-[3rem] leading-relaxed">{{ $ticket->description }}</p>
                
                <div class="flex items-end gap-2 mb-8 border-t border-gray-100 pt-6">
                    <span class="text-4xl font-extrabold text-primary">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                    <span class="text-gray-400 mb-1 font-medium">/ org</span>
                </div>
                
                <a href="{{ route('reservations.create') }}" class="block w-full text-center py-3 px-4 rounded-xl font-medium text-primary bg-primary/10 hover:bg-primary hover:text-white transition-colors duration-300">Pilih Tiket</a>
            </div>
            @empty
            <div class="col-span-3 text-center py-16 text-gray-500 bg-white rounded-3xl border border-dashed border-gray-300">
                Belum ada tiket yang tersedia.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
