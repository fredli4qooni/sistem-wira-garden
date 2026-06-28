@extends('layouts.public')

@section('content')
<div class="bg-background py-20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-primary font-heading tracking-tight sm:text-6xl mb-4">Galeri Wira Garden</h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto font-light">Potret keindahan alam dan momen tak terlupakan pengunjung kami.</p>
            <div class="w-24 h-1.5 bg-accent mx-auto mt-8 rounded-full"></div>
        </div>

        <div class="columns-1 sm:columns-2 md:columns-3 gap-6 space-y-6" x-data="{ lightboxOpen: false, activeImage: '' }">
            @forelse($galleries as $gallery)
            <div @click="activeImage = '{{ Storage::url($gallery->image_path) }}'; lightboxOpen = true" class="break-inside-avoid relative group overflow-hidden rounded-[2rem] shadow-md hover:shadow-2xl transition-all duration-500 mb-6 bg-gray-100 cursor-pointer">
                <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-auto object-cover transform group-hover:scale-110 transition-transform duration-700">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent opacity-70 group-hover:opacity-90 transition-opacity duration-300"></div>
                
                <div class="absolute inset-x-0 bottom-0 p-6 flex flex-col justify-end transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                    @if($gallery->category)
                    <div class="flex items-center gap-1.5 px-3 py-1 bg-primary/90 backdrop-blur-md text-white text-xs font-bold rounded-full mb-3 w-max tracking-wide shadow-lg border border-white/20">
                        @if($gallery->icon_type == 'svg' && $gallery->icon)
                            @if(str_contains($gallery->icon, '<svg'))
                                <div class="[&>svg]:w-3 [&>svg]:h-3 flex items-center justify-center">
                                    {!! $gallery->icon !!}
                                </div>
                            @else
                                <i class="{{ $gallery->icon }} text-xs"></i>
                            @endif
                        @endif
                        <span>{{ $gallery->category }}</span>
                    </div>
                    @endif
                    <h3 class="text-white font-bold text-xl md:text-2xl font-heading tracking-wide drop-shadow-md group-hover:text-primary transition-colors">{{ $gallery->title }}</h3>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-500 py-16 bg-white rounded-3xl border border-dashed border-gray-200">
                Belum ada foto di galeri.
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
