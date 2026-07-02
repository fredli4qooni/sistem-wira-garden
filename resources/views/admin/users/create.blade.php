<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-primary transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            Tambah Pengguna Baru
        </div>
    </x-slot>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 max-w-3xl">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-semibold text-charcoal mb-2">Password</label>
                        <input type="password" name="password" required minlength="8" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password Confirmation -->
                    <div>
                        <label class="block text-sm font-semibold text-charcoal mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required minlength="8" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-semibold text-charcoal mb-2">Peran (Role)</label>
                    <select name="role" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">
                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User (Pengunjung)</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 border border-gray-200 text-gray-600 font-medium rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="bg-primary hover:bg-secondary text-white font-medium py-3 px-8 rounded-xl transition-colors shadow-sm hover:shadow-md">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
