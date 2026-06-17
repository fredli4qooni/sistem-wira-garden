<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.galleries.index') }}" class="text-gray-400 hover:text-primary transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-primary leading-tight font-heading">
                Edit Foto Galeri
            </h2>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl mx-auto">
        <div class="p-6 sm:p-8">
            <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="title" class="block text-sm font-semibold text-charcoal mb-2">Judul Foto</label>
                    <input type="text" name="title" id="title" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" value="{{ old('title', $gallery->title) }}">
                    @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-semibold text-charcoal mb-2">Kategori <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="category" id="category" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" value="{{ old('category', $gallery->category) }}">
                    @error('category') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-3">Foto Saat Ini</label>
                    <div class="relative w-48 h-32 rounded-xl overflow-hidden border border-gray-200">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
                    </div>
                </div>

                <div>
                    <label for="image" class="block text-sm font-semibold text-charcoal mb-2">Ganti Foto Baru <span class="text-gray-400 font-normal">(Opsional, JPEG/PNG/JPG maks 2MB)</span></label>
                    <input type="file" name="image" id="image" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-secondary/10 file:text-secondary hover:file:bg-secondary/20">
                    @error('image') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center mt-4">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="rounded border-gray-300 text-secondary shadow-sm focus:ring-secondary w-5 h-5" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-3 block text-sm font-medium text-gray-700">Tampilkan foto ini di Halaman Publik</label>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.galleries.index') }}" class="px-6 py-3 text-gray-600 font-medium hover:text-gray-900 transition-colors">Batal</a>
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-medium py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:-translate-y-0.5">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
