<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.tickets.index') }}" class="text-gray-400 hover:text-primary transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-primary leading-tight font-heading">
                Edit Tiket: {{ $ticket->name }}
            </h2>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl mx-auto">
        <div class="p-6 sm:p-8">
            <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="name" class="block text-sm font-semibold text-charcoal mb-2">Nama Tiket</label>
                    <input type="text" name="name" id="name" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" value="{{ old('name', $ticket->name) }}">
                    @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-charcoal mb-2">Deskripsi</label>
                    <textarea name="description" id="description" rows="3" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">{{ old('description', $ticket->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-semibold text-charcoal mb-2">Harga (Rp)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-semibold">Rp</span>
                        </div>
                        <input type="number" name="price" id="price" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 pl-12 pr-4 bg-gray-50 focus:bg-white" value="{{ old('price', $ticket->price) }}">
                    </div>
                    @error('price') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center mt-4">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="rounded border-gray-300 text-secondary shadow-sm focus:ring-secondary w-5 h-5" {{ old('is_active', $ticket->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-3 block text-sm font-medium text-gray-700">Aktifkan tiket ini untuk dibeli</label>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.tickets.index') }}" class="px-6 py-3 text-gray-600 font-medium hover:text-gray-900 transition-colors">Batal</a>
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-medium py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:-translate-y-0.5">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
