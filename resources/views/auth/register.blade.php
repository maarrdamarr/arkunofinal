<x-auth-layout>
    <div class="mb-6 text-center">
        <h2 class="font-serif text-2xl font-bold text-emerald-950">Exclusive Membership</h2>
        <p class="text-sm text-gray-500 mt-1">Bergabunglah dengan kolektor elit dunia</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-emerald-900 font-bold text-xs uppercase tracking-wider" />
            <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg shadow-sm bg-gray-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')" class="text-emerald-900 font-bold text-xs uppercase tracking-wider" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg shadow-sm bg-gray-50" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-emerald-900 font-bold text-xs uppercase tracking-wider" />

            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg shadow-sm bg-gray-50"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-emerald-900 font-bold text-xs uppercase tracking-wider" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg shadow-sm bg-gray-50"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <div>
                <a class="underline text-sm text-gray-500 hover:text-emerald-700 transition" href="{{ route('login') }}">
                    {{ __('Sudah terdaftar?') }}
                </a>
                <div class="mt-2">
                    <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-800">Back</a>
                </div>
            </div>

            <x-primary-button class="bg-emerald-900 hover:bg-emerald-800 text-white font-bold shadow-lg border-none rounded-full px-6 py-2">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>
    </form>
</x-auth-layout>