<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-primary font-heading mb-2">Buat Akun Baru</h2>
        <p class="text-gray-500 text-sm">Silakan lengkapi form di bawah ini untuk mendaftar sebagai pengunjung.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-charcoal mb-2">Nama Lengkap</label>
            <input id="name" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-charcoal mb-2">Email Address</label>
            <input id="email" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-charcoal mb-2">Password</label>
            <input id="password" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-charcoal mb-2">Konfirmasi Password</label>
            <input id="password_confirmation" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-sm" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-medium py-3 px-4 rounded-xl transition-all duration-300 shadow-md hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2">
                Daftar Sekarang
            </button>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-primary hover:text-secondary transition-colors">
                    Log in di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
