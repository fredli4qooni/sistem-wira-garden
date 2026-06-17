<x-app-layout>
    <x-slot name="header">
        Manajemen Galeri
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800 font-heading">Galeri Foto</h3>
        <a href="{{ route('admin.galleries.create') }}" class="bg-primary hover:bg-secondary text-white font-medium py-2.5 px-5 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Tambah Foto
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($galleries as $item)
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm relative group hover:shadow-md transition-shadow">
            <div class="relative h-48 overflow-hidden">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            
            <div class="p-4">
                <h4 class="font-bold text-gray-900 truncate">{{ $item->title }}</h4>
                <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider font-semibold">{{ $item->category ?? 'Umum' }}</p>
            </div>
            
            <!-- Hover Actions -->
            <div class="absolute top-3 right-3 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity translate-x-4 group-hover:translate-x-0 duration-300">
                <a href="{{ route('admin.galleries.edit', $item) }}" class="bg-white/90 backdrop-blur p-2 rounded-xl shadow-sm text-secondary hover:text-primary hover:bg-white transition-colors" title="Edit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </a>
                <form action="{{ route('admin.galleries.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-white/90 backdrop-blur p-2 rounded-xl shadow-sm text-red-500 hover:text-red-700 hover:bg-white transition-colors" title="Hapus">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl border border-dashed border-gray-200 py-16 flex flex-col items-center justify-center">
            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <p class="text-gray-500 font-medium text-lg">Belum ada foto galeri.</p>
        </div>
        @endforelse
    </div>
</x-app-layout>
