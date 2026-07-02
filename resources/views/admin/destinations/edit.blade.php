<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.destinations.index') }}" class="text-gray-400 hover:text-primary transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-primary leading-tight font-heading">
                Edit Destinasi: {{ $destination->name }}
            </h2>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl mx-auto">
        <div class="p-6 sm:p-8">
            <form action="{{ route('admin.destinations.update', $destination) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="name" class="block text-sm font-semibold text-charcoal mb-2">Nama Destinasi</label>
                    <input type="text" name="name" id="name" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" value="{{ old('name', $destination->name) }}">
                    @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-semibold text-charcoal mb-2">Foto Sampul (Utama)</label>
                    @if($destination->image_path)
                    <div class="mb-4">
                        <img src="{{ Storage::url($destination->image_path) }}" alt="{{ $destination->name }}" class="h-32 rounded-xl object-cover shadow-sm">
                    </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-2 px-4 bg-gray-50 focus:bg-white text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah foto sampul.</p>
                    @error('image') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div x-data="galleryUploader()">
                    <label class="block text-sm font-semibold text-charcoal mb-2">Foto Galeri (Bisa tambah lebih dari satu)</label>
                    
                    @if(is_array($destination->gallery_images) && count($destination->gallery_images) > 0)
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-2">Galeri Lama:</p>
                        <div class="flex flex-wrap gap-4">
                            @foreach($destination->gallery_images as $path)
                                <img src="{{ Storage::url($path) }}" class="h-24 w-24 rounded-xl object-cover shadow-sm border border-gray-200">
                            @endforeach
                        </div>
                        <label class="inline-flex items-center mt-3 bg-red-50 p-2 rounded-lg border border-red-100 cursor-pointer">
                            <input type="checkbox" name="clear_gallery" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                            <span class="ml-2 text-sm text-red-600 font-medium">Hapus semua foto galeri lama di atas</span>
                        </label>
                    </div>
                    @endif

                    <p class="text-xs text-gray-500 mb-2">Tambah Foto Baru:</p>
                    <div class="flex flex-wrap gap-4 mb-2">
                        <template x-for="(imageUrl, index) in imageUrls" :key="index">
                            <div class="relative h-24 w-24 rounded-xl overflow-hidden shadow-sm border border-gray-200 group">
                                <img :src="imageUrl" class="w-full h-full object-cover">
                                <button type="button" @click="removeImage(index)" class="absolute top-1 right-1 bg-red-500/80 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </template>

                        <label class="h-24 w-24 rounded-xl border-2 border-dashed border-gray-300 hover:border-primary hover:bg-primary/5 flex flex-col items-center justify-center cursor-pointer transition-colors text-gray-500 hover:text-primary">
                            <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span class="text-xs font-semibold">Tambah</span>
                            <input type="file" multiple accept="image/*" class="hidden" @change="addImages">
                        </label>
                    </div>
                    
                    <input type="file" name="gallery[]" id="hidden_gallery_input" multiple class="hidden">
                    <p class="text-xs text-gray-500 mt-2">Pilih gambar untuk ditambahkan ke galeri destinasi.</p>
                    @error('gallery.*') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-charcoal mb-2">Kategori Destinasi</label>
                        <select id="category_id" name="category_id" required
                            class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">
                            <option value="" disabled>Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $destination->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div x-data="{ pricingType: '{{ old('pricing_type', $destination->pricing_type) }}' }">
                    <div class="mb-6">
                        <label for="pricing_type" class="block text-sm font-semibold text-charcoal mb-2">Tipe Harga</label>
                        <select id="pricing_type" name="pricing_type" x-model="pricingType" required
                            class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">
                            <option value="per_person">Per Orang (Dewasa & Anak)</option>
                            <option value="per_package">Per Paket / Tenda</option>
                        </select>
                        @error('pricing_type') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price_adult" class="block text-sm font-semibold text-charcoal mb-2" x-text="pricingType === 'per_package' ? 'Harga Per Paket (Rp)' : 'Harga Dewasa (Rp)'">Harga Dewasa (Rp)</label>
                            <input type="number" name="price_adult" id="price_adult" required min="0" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" value="{{ old('price_adult', $destination->price_adult) }}">
                            @error('price_adult') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div x-show="pricingType === 'per_person'">
                            <label for="price_child" class="block text-sm font-semibold text-charcoal mb-2">Harga Anak-anak (Rp)</label>
                            <input type="number" name="price_child" id="price_child" min="0" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" value="{{ old('price_child', $destination->price_child) }}">
                            @error('price_child') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div x-show="pricingType === 'per_package'" style="display: none;">
                    <label for="total_stock" class="block text-sm font-semibold text-charcoal mb-2">Total Stok Unit / Tenda <span class="text-gray-400 font-normal">(Kosongkan jika tidak terbatas)</span></label>
                    <input type="number" name="total_stock" id="total_stock" min="1" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white max-w-sm" value="{{ old('total_stock', $destination->total_stock) }}">
                    <p class="text-xs text-gray-500 mt-2">Menentukan jumlah maksimal pesanan paket/tenda per harinya.</p>
                    @error('total_stock') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-2">Fasilitas <span class="text-gray-400 font-normal">(Pilih fasilitas yang tersedia)</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @php
                            $selectedFacilities = old('facilities', is_array($destination->facilities) ? $destination->facilities : []);
                        @endphp
                        @foreach($facilities as $facility)
                        <label class="inline-flex items-center p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="checkbox" name="facilities[]" value="{{ $facility->id }}" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary h-5 w-5" {{ in_array($facility->id, $selectedFacilities) ? 'checked' : '' }}>
                            <span class="ml-3 text-sm text-gray-700 font-medium">{{ $facility->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('facilities') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-charcoal mb-2">Deskripsi</label>
                    <textarea name="description" id="description" rows="4" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">{{ old('description', $destination->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-semibold text-charcoal mb-2">Alamat Lengkap</label>
                    <input type="text" name="address" id="address" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" value="{{ old('address', $destination->address) }}">
                    @error('address') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-2">Jam Operasional</label>
                    <input type="hidden" name="open_hours" id="open_hours" value="{{ old('open_hours', $destination->open_hours) }}">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <input type="text" id="open_time" class="time-picker block w-full pl-10 border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 bg-gray-50 focus:bg-white cursor-pointer" placeholder="08:00">
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <input type="text" id="close_time" class="time-picker block w-full pl-10 border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 bg-gray-50 focus:bg-white cursor-pointer" placeholder="17:00">
                        </div>
                    </div>
                    @error('open_hours') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="maps_url" class="block text-sm font-semibold text-charcoal mb-2">URL Google Maps <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="url" name="maps_url" id="maps_url" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" value="{{ old('maps_url', $destination->maps_url) }}">
                    @error('maps_url') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.destinations.index') }}" class="px-6 py-3 text-gray-600 font-medium hover:text-gray-900 transition-colors">Batal</a>
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-medium py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:-translate-y-0.5">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('galleryUploader', () => ({
                imageUrls: [],
                files: [],
                addImages(event) {
                    const newFiles = Array.from(event.target.files);
                    newFiles.forEach(file => {
                        this.files.push(file);
                        this.imageUrls.push(URL.createObjectURL(file));
                    });
                    this.updateFileInput();
                    event.target.value = '';
                },
                removeImage(index) {
                    this.files.splice(index, 1);
                    URL.revokeObjectURL(this.imageUrls[index]);
                    this.imageUrls.splice(index, 1);
                    this.updateFileInput();
                },
                updateFileInput() {
                    const dataTransfer = new DataTransfer();
                    this.files.forEach(file => {
                        dataTransfer.items.add(file);
                    });
                    document.getElementById('hidden_gallery_input').files = dataTransfer.files;
                }
            }));
        });

        document.addEventListener('DOMContentLoaded', function() {
            const openTime = document.getElementById('open_time');
            const closeTime = document.getElementById('close_time');
            const openHours = document.getElementById('open_hours');

            if (openHours.value && openHours.value.includes(' - ')) {
                const parts = openHours.value.split(' - ');
                openTime.value = parts[0].trim();
                closeTime.value = parts[1].trim();
            } else {
                openTime.value = '08:00';
                closeTime.value = '17:00';
            }

            function updateOpenHours() {
                openHours.value = `${openTime.value} - ${closeTime.value}`;
            }

            openTime.addEventListener('change', updateOpenHours);
            closeTime.addEventListener('change', updateOpenHours);
        });
    </script>
</x-app-layout>
