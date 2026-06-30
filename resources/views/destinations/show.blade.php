@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-8">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-primary">Beranda</a>
                    <span class="mx-2">/</span>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('destinations.index') }}" class="hover:text-primary">Wisata</a>
                    <span class="mx-2">/</span>
                </li>
                <li class="flex items-center text-gray-800">
                    {{ $destination->name }}
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- Left: Image -->
                <div class="h-96 md:h-auto relative">
                    <img src="{{ $destination->image_path ? Storage::url($destination->image_path) : 'https://images.unsplash.com/photo-1596436889106-be35e843f974?q=80&w=1000&auto=format&fit=crop' }}" alt="{{ $destination->name }}" class="absolute inset-0 w-full h-full object-cover">
                </div>
                
                <!-- Right: Content -->
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <h1 class="text-4xl font-bold text-gray-900 font-heading mb-2">{{ $destination->name }}</h1>
                    
                    <p class="text-gray-500 mb-4">Kategori : {{ $destination->category ? $destination->category->name : '-' }}</p>
                    
                    @if($destination->pricing_type === 'per_package')
                        <div class="mb-6">
                            <div class="bg-orange-50/50 p-4 rounded-xl border border-orange-100 max-w-sm">
                                <p class="text-sm text-gray-500 mb-1">Harga Paket / Tenda</p>
                                <p class="text-2xl font-bold text-orange-500">Rp {{ number_format($destination->price_adult, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col sm:flex-row gap-4 mb-6">
                            <div class="bg-primary/5 p-4 rounded-xl border border-primary/20">
                                <p class="text-sm text-gray-500 mb-1">Tiket Dewasa</p>
                                <p class="text-2xl font-bold text-primary">Rp {{ number_format($destination->price_adult, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-primary/5 p-4 rounded-xl border border-primary/20">
                                <p class="text-sm text-gray-500 mb-1">Tiket Anak-anak</p>
                                <p class="text-2xl font-bold text-primary">Rp {{ number_format($destination->price_child, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <p class="text-gray-600 leading-relaxed mb-8">
                        {!! nl2br(e($destination->description)) !!}
                    </p>
                    
                    @if(isset($facilities) && count($facilities) > 0)
                    <div class="mb-8">
                        <h3 class="font-bold text-gray-900 mb-4">Fasilitas :</h3>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($facilities as $facility)
                            <li class="flex items-center text-gray-600 bg-gray-50 rounded-xl p-3 border border-gray-100">
                                @if($facility->image_path)
                                    <img src="{{ Storage::url($facility->image_path) }}" class="w-8 h-8 rounded-full object-cover mr-3 border border-gray-200" alt="{{ $facility->name }}">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 text-green-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                @endif
                                <span class="font-medium text-sm">{{ $facility->name }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <div class="mt-auto pt-8">
                        <a href="{{ route('reservations.create', ['destination_id' => $destination->id]) }}" class="inline-block bg-primary text-white font-bold py-3 px-8 rounded-xl shadow hover:bg-green-700 transition-colors">
                            Reservasi Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info & Gallery -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Informasi -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 font-heading">Informasi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center shrink-0 mr-4">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Jam Operasional</p>
                            <p class="text-gray-500 text-sm mt-1">{{ $destination->open_hours }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center shrink-0 mr-4">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">Lokasi</p>
                            <p class="text-gray-500 text-sm mt-1">{{ $destination->address }}</p>
                            @if($destination->maps_url)
                            <a href="{{ $destination->maps_url }}" target="_blank" class="text-secondary text-sm mt-2 inline-block hover:underline">Lihat di Maps</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Galeri -->
            <div x-data="{ lightboxOpen: false, activeImage: '' }">
                <h3 class="text-xl font-bold text-gray-900 mb-6 font-heading">Galeri</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @if(is_array($destination->gallery_images) && count($destination->gallery_images) > 0)
                        @foreach($destination->gallery_images as $path)
                        <div @click="activeImage = '{{ Storage::url($path) }}'; lightboxOpen = true" class="aspect-square rounded-2xl overflow-hidden shadow-sm cursor-pointer group">
                            <img src="{{ Storage::url($path) }}" alt="Galeri {{ $destination->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        @endforeach
                    @else
                        <div class="col-span-4 text-center text-gray-400 py-8 border border-dashed rounded-2xl">Belum ada foto galeri spesifik untuk destinasi ini.</div>
                    @endif
                </div>

                <!-- Lightbox Modal -->
                <div x-show="lightboxOpen" 
                     style="display: none;"
                     class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @keydown.escape.window="lightboxOpen = false">
                     
                    <!-- Close Button -->
                    <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white/70 hover:text-white bg-black/50 hover:bg-black/80 rounded-full p-2 transition-all">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <!-- Image -->
                    <img :src="activeImage" @click.outside="lightboxOpen = false" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl" alt="Preview">
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
