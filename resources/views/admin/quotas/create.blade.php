<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.quotas.index') }}" class="text-gray-400 hover:text-primary transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-primary leading-tight font-heading">
                Tambah Kuota Harian
            </h2>
        </div>
    </x-slot>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl mx-auto">
        <div class="p-6 sm:p-8">
            <form action="{{ route('admin.quotas.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="date" class="block text-sm font-semibold text-charcoal mb-2">Tanggal</label>
                    <input type="date" name="date" id="date" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" value="{{ old('date') }}">
                    @error('date') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="max_quota" class="block text-sm font-semibold text-charcoal mb-2">Maksimal Kuota Kunjungan</label>
                    <input type="number" name="max_quota" id="max_quota" required min="1" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" value="{{ old('max_quota', 500) }}">
                    @error('max_quota') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center mt-4">
                    <input type="checkbox" name="is_blocked" id="is_blocked" value="1" class="rounded border-gray-300 text-red-500 shadow-sm focus:ring-red-500 w-5 h-5" {{ old('is_blocked') ? 'checked' : '' }}>
                    <label for="is_blocked" class="ml-3 block text-sm font-medium text-gray-700">Blokir Kunjungan (Tutup pada tanggal ini)</label>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.quotas.index') }}" class="px-6 py-3 text-gray-600 font-medium hover:text-gray-900 transition-colors">Batal</a>
                    <button type="submit" class="bg-primary hover:bg-secondary text-white font-medium py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:-translate-y-0.5">Simpan Kuota</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
