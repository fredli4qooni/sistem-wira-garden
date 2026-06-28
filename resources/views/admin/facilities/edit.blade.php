<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.facilities.index') }}" class="text-gray-400 hover:text-primary transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-primary leading-tight font-heading">
                Edit Fasilitas
            </h2>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
        <form action="{{ route('admin.facilities.update', $facility) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Fasilitas <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $facility->name) }}" required class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-gray-700">
                @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Lengkap</label>
                <textarea name="description" rows="4" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-gray-700">{{ old('description', $facility->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto / Gambar Fasilitas</label>
                @if($facility->image_path)
                    <div class="mb-4">
                        <img src="{{ Storage::url($facility->image_path) }}" alt="Current Image" class="h-32 rounded-xl border border-gray-200 object-cover">
                    </div>
                @endif
                <input type="file" name="image_path" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors">
                <p class="text-xs text-gray-400 mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                @error('image_path') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $facility->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-primary focus:ring-primary h-5 w-5 cursor-pointer">
                <label for="is_active" class="text-sm font-medium text-gray-700 cursor-pointer">Fasilitas Aktif (Tampilkan ke Publik)</label>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.facilities.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-2.5 rounded-xl transition-colors font-semibold">Batal</a>
                <button type="submit" class="bg-primary hover:bg-secondary text-white px-6 py-2.5 rounded-xl transition-colors font-bold shadow-md shadow-primary/20">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app-layout>
