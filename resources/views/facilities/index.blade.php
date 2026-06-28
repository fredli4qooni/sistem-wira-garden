@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-4xl sm:text-5xl font-bold text-charcoal mb-4">Fasilitas <span class="text-primary font-heading">Wira Garden</span></h1>
            <p class="text-lg text-gray-500">Kami menyediakan berbagai fasilitas untuk menunjang kenyamanan dan kepuasan pengunjung selama berwisata.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-data="{ lightboxOpen: false, activeImage: '' }">
            @forelse($facilities as $facility)
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                    @if($facility->image_path)
                    <div class="relative h-56 w-full overflow-hidden cursor-pointer" @click="activeImage = '{{ Storage::url($facility->image_path) }}'; lightboxOpen = true">
                        <img src="{{ Storage::url($facility->image_path) }}" alt="{{ $facility->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    @else
                    <div class="relative h-56 w-full bg-gray-50 flex items-center justify-center text-gray-300">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    @endif
                    <div class="p-8">
                        <h3 class="text-2xl font-bold text-charcoal mb-3 font-heading group-hover:text-primary transition-colors">{{ $facility->name }}</h3>
                        @if($facility->description)
                        <p class="text-gray-500 text-base leading-relaxed line-clamp-3">{{ $facility->description }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada fasilitas</h3>
                    <p class="text-gray-500">Data fasilitas belum ditambahkan ke dalam sistem.</p>
                </div>
            @endforelse
            
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
@endsection
