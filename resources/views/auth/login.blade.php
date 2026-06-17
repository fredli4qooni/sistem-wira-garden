<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-primary font-heading mb-2">Selamat Datang</h2>
        <p class="text-gray-500 text-sm">Silakan masukkan kredensial Anda untuk masuk ke sistem.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-charcoal mb-2">Email Address</label>
            <input id="email" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-charcoal mb-2">Password</label>
            <input id="password" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-secondary shadow-sm focus:ring-secondary" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-secondary hover:text-primary transition-colors" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-medium py-3 px-4 rounded-xl transition-all duration-300 shadow-md hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2">
                Log in ke Dashboard
            </button>
        </div>
    </form>
</x-guest-layout>
