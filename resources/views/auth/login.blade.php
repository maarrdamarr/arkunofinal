<x-auth-layout>
    <div class="mb-6 text-center">
        <h2 class="font-serif text-2xl font-bold text-emerald-950">Member Login</h2>
        <p class="text-sm text-gray-500 mt-1">Masuk untuk menawar barang eksklusif</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-emerald-900 font-bold text-xs uppercase tracking-wider" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg shadow-sm bg-gray-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-emerald-900 font-bold text-xs uppercase tracking-wider" />

            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg shadow-sm bg-gray-50"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-yellow-600 shadow-sm focus:ring-yellow-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-emerald-700 hover:text-yellow-600 transition" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif

            <x-primary-button class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-emerald-950 font-bold shadow-lg border-none rounded-full px-6">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-auth-layout>