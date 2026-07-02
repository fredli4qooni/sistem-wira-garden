@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gray-900 overflow-hidden min-h-screen flex items-center justify-start">
    <div class="absolute inset-0">
        <!-- Main Background Image -->
        <img class="w-full h-full object-cover" src="{{ asset(setting('hero_image', 'images/gambar-wira-garden.png')) }}" alt="Wira Garden Nature">
        
        <!-- Overlays for better text readability -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10 pt-20 pb-10">
        <!-- Text Content -->
        <div class="max-w-2xl text-left">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-2 drop-shadow-md">
                {{ setting('hero_subtitle', 'Nikmati Keindahan Alam') }}
            </h2>
            
            <h1 class="text-6xl md:text-8xl font-extrabold text-white mb-6 leading-tight drop-shadow-xl tracking-tight">
                {{ setting('hero_title', 'Wira Garden') }}
            </h1>
            
            <p class="text-lg md:text-xl text-gray-200 mb-10 leading-relaxed font-medium drop-shadow-md max-w-xl">
                {{ setting('hero_description', 'Tempat wisata alam yang asri dan menyenangkan untuk semua.') }}
            </p>
            
            <div>
                <a href="{{ route('reservations.create') }}" class="inline-flex justify-center items-center gap-2 bg-primary hover:bg-[#036545] text-white font-bold text-lg px-8 py-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-2xl hover:-translate-y-1">
                    Reservasi Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Mengapa Wira Garden Section -->
<div class="py-24 bg-white relative z-20 shadow-[0_-20px_40px_-15px_rgba(0,0,0,0.1)]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-12 font-heading tracking-tight text-center md:text-left">Mengapa Wira Garden?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center hover:shadow-xl hover:border-primary/20 transition-all duration-300 group">
                <div class="w-16 h-16 mx-auto mb-6 text-primary flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-3 text-lg">Alam yang Asri</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Dikelilingi pepohonan hijau dan udara segar.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center hover:shadow-xl hover:border-primary/20 transition-all duration-300 group">
                <div class="w-16 h-16 mx-auto mb-6 text-primary flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-3 text-lg">Fasilitas Lengkap</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Fasilitas nyaman untuk pengunjung.</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center hover:shadow-xl hover:border-primary/20 transition-all duration-300 group">
                <div class="w-16 h-16 mx-auto mb-6 text-primary flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-3 text-lg">Aktivitas Menarik</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Berbagai wahana dan aktivitas seru.</p>
            </div>
            
            <!-- Feature 4 -->
            <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center hover:shadow-xl hover:border-primary/20 transition-all duration-300 group">
                <div class="w-16 h-16 mx-auto mb-6 text-primary flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-3 text-lg">Harga Terjangkau</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Harga tiket yang ramah di kantong.</p>
            </div>
        </div>
    </div>
</div>

<!-- Destinasi Unggulan Section -->
<div class="py-24 bg-gray-50 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 font-heading tracking-tight mb-2">Destinasi Unggulan</h2>
                <p class="text-gray-500">Spot favorit pengunjung Wira Garden.</p>
            </div>
            <a href="{{ route('destinations.index') }}" class="hidden sm:inline-flex items-center gap-2 text-primary font-semibold hover:text-secondary transition-colors group">
                Lihat Semua
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($destinations as $destination)
            <div class="bg-white rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 p-3 group flex flex-col">
                <!-- Image Area -->
                <div class="h-48 overflow-hidden relative rounded-[1.5rem]">
                    @if($destination->image_path)
                    <img src="{{ Storage::url($destination->image_path) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    @endif
                    
                    <!-- Category Badge -->
                    @if($destination->category)
                    <div class="absolute top-3 right-3 bg-white/95 backdrop-blur px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-sm">
                        @if($destination->category->icon_type == 'image' && $destination->category->icon_value)
                            <img src="{{ Storage::url($destination->category->icon_value) }}" alt="Icon" class="w-3.5 h-3.5 rounded-sm object-cover">
                        @elseif($destination->category->icon_type == 'svg' && $destination->category->icon_value)
                            <div class="text-green-600 flex items-center justify-center">
                                @php
                                    $iconVal = html_entity_decode($destination->category->icon_value);
                                @endphp
                                @if(str_contains($iconVal, '<svg'))
                                    <div class="[&>svg]:w-3.5 [&>svg]:h-3.5">
                                        {!! $iconVal !!}
                                    </div>
                                @else
                                    <i class="{{ $destination->category->icon_value }} text-sm"></i>
                                @endif
                            </div>
                        @else
                            <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @endif
                        <span class="text-[11px] font-bold text-green-700">{{ $destination->category->name }}</span>
                    </div>
                    @endif
                </div>
                
                <!-- Content Area -->
                <div class="pt-5 pb-2 px-2 flex flex-col flex-grow">
                    <!-- Title and Desc -->
                    <div class="flex gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center shrink-0 border border-green-100 overflow-hidden">
                            @if($destination->category && $destination->category->icon_type == 'image' && $destination->category->icon_value)
                                <img src="{{ Storage::url($destination->category->icon_value) }}" alt="Icon" class="w-full h-full object-cover">
                            @elseif($destination->category && $destination->category->icon_type == 'svg' && $destination->category->icon_value)
                                <div class="text-green-600 flex items-center justify-center h-full">
                                    @php
                                        $iconVal2 = html_entity_decode($destination->category->icon_value);
                                    @endphp
                                    @if(str_contains($iconVal2, '<svg'))
                                        <div class="[&>svg]:w-5 [&>svg]:h-5">
                                            {!! $iconVal2 !!}
                                        </div>
                                    @else
                                        <i class="{{ $destination->category->icon_value }} text-xl"></i>
                                    @endif
                                </div>
                            @else
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-charcoal mb-1 leading-tight group-hover:text-primary transition-colors">{{ $destination->name }}</h2>
                            <p class="text-gray-500 text-[13px] line-clamp-2 leading-relaxed">{{ $destination->description }}</p>
                        </div>
                    </div>
                    
                    <hr class="border-dashed border-gray-200 mb-4 mt-auto">
                    
                    <!-- Prices & Stock -->
                    <div class="bg-gray-50/80 rounded-xl border border-gray-100 p-3 mb-4 space-y-2.5">
                        @if($destination->total_stock !== null)
                            <div class="flex items-center justify-between pb-2 mb-2 border-b border-gray-100 border-dashed">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <div class="w-6 h-6 rounded-full bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    </div>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-green-700">Kuota Harian</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[11px] font-bold text-green-700 bg-green-100 px-2 py-0.5 rounded-md block mb-1">{{ $destination->total_stock }} Unit</span>
                                    @php $availableToday = $destination->getAvailableStock(date('Y-m-d')); @endphp
                                    <span class="text-[10px] {{ $availableToday > 0 ? 'text-green-600' : 'text-red-500' }} block">Sisa hari ini: {{ $availableToday }}</span>
                                </div>
                            </div>
                        @endif

                        @if($destination->pricing_type === 'per_package')
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <div class="w-6 h-6 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <span class="text-[11px] font-medium uppercase tracking-wider">Harga Paket</span>
                                </div>
                                <span class="text-sm font-bold text-[#0071ba]">Rp {{ number_format($destination->price_adult, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <div class="w-6 h-6 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <span class="text-[11px] font-medium uppercase tracking-wider">Dewasa</span>
                                </div>
                                <span class="text-sm font-bold text-[#0071ba]">Rp {{ number_format($destination->price_adult, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <div class="w-6 h-6 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <span class="text-[11px] font-medium uppercase tracking-wider">Anak-anak</span>
                                </div>
                                <span class="text-sm font-bold text-green-600">Rp {{ number_format($destination->price_child, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <a href="{{ route('destinations.show', $destination->id) }}" class="w-full flex items-center justify-center gap-2 bg-[#0071ba] text-white py-3 rounded-[1rem] font-bold hover:bg-[#005a96] transition-colors text-sm">
                        Lihat Detail
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-gray-400 py-12 bg-white rounded-2xl border border-dashed border-gray-200">
                Belum ada data destinasi.
            </div>
            @endforelse
        </div>
        
        <div class="mt-8 text-center sm:hidden">
            <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-2 text-primary font-semibold hover:text-secondary transition-colors">
                Lihat Semua Destinasi
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</div>

@endsection
