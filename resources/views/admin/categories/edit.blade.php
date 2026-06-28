<x-app-layout>
    <x-slot name="header">
        Edit Kategori
    </x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-800 font-heading">Edit Kategori: {{ $category->name }}</h3>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-primary font-medium flex items-center gap-2 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8" x-data="{ iconType: '{{ old('icon_type', $category->icon_type) }}', previewSvg: `{{ old('icon_svg', $category->icon_type == 'svg' ? $category->icon_value : '') }}` }">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-charcoal mb-2">Nama Kategori</label>
                        <input type="text" name="name" id="name" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" value="{{ old('name', $category->name) }}" placeholder="Contoh: Petualangan, Wahana Air">
                        @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-charcoal mb-3">Tipe Ikon</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="icon_type" value="svg" x-model="iconType" class="text-primary focus:ring-primary">
                                <span class="text-gray-700">Ikon (FontAwesome)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="icon_type" value="image" x-model="iconType" class="text-primary focus:ring-primary">
                                <span class="text-gray-700">Unggah Gambar</span>
                            </label>
                        </div>
                        @error('icon_type') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div x-show="iconType === 'svg'" x-transition class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                        <label for="icon_svg" class="block text-sm font-semibold text-charcoal mb-2">Pilih Ikon</label>
                        <p class="text-xs text-gray-500 mb-3">Klik kotak di bawah ini untuk memilih ikon dari library FontAwesome.</p>
                        
                        <div class="relative max-w-sm">
                            <input type="text" name="icon_svg" id="icon_picker" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 pl-12 bg-white" placeholder="fas fa-tree" value="{{ old('icon_svg', $category->icon_type == 'svg' ? $category->icon_value : 'fas fa-tree') }}" autocomplete="off">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="{{ old('icon_svg', $category->icon_type == 'svg' ? $category->icon_value : 'fas fa-tree') }} text-green-600 text-lg" id="icon_preview"></i>
                            </div>
                        </div>
                        @error('icon_svg') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div x-show="iconType === 'image'" x-transition style="display: none;" class="p-4 rounded-xl border border-gray-200 bg-gray-50">
                        <label for="icon_image" class="block text-sm font-semibold text-charcoal mb-2">Unggah Gambar Ikon</label>
                        <p class="text-xs text-gray-500 mb-3">Format: JPG, PNG, WEBP, SVG. Maks 2MB. Kosongkan jika tidak ingin mengganti gambar saat ini.</p>
                        
                        @if($category->icon_type == 'image' && $category->icon_value)
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 mb-2">Gambar Saat Ini:</p>
                                <img src="{{ Storage::url($category->icon_value) }}" alt="Ikon saat ini" class="h-16 w-16 object-cover rounded-xl border border-gray-200">
                            </div>
                        @endif

                        <input type="file" name="icon_image" id="icon_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-colors">
                        @error('icon_image') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary transition-colors">
                            <span class="text-gray-700 font-medium">Kategori Aktif</span>
                        </label>
                        <p class="text-xs text-gray-500 ml-8 mt-1">Jika dinonaktifkan, kategori ini tidak akan muncul saat membuat destinasi baru.</p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white font-medium hover:bg-secondary shadow-sm hover:shadow-md transition-all">Update Kategori</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#icon_picker').iconpicker({
                placement: 'bottomRight',
                hideOnSelect: true,
                inputSearch: true,
            }).on('iconpickerSelected', function(event) {
                $('#icon_preview').attr('class', event.iconpickerValue + ' text-green-600 text-lg');
            });

            // Set initial preview class if there's a value
            var initialIcon = $('#icon_picker').val();
            if(initialIcon) {
                $('#icon_preview').attr('class', initialIcon + ' text-green-600 text-lg');
            }
        });
    </script>
    @endpush
</x-app-layout>
