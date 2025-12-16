<x-auth-layout>
    <div class="mb-6 text-center">
        <h2 class="font-serif text-2xl font-bold text-emerald-950">New Credentials</h2>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-emerald-900 font-bold text-xs uppercase tracking-wider" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg shadow-sm bg-gray-50" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password Baru')" class="text-emerald-900 font-bold text-xs uppercase tracking-wider" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg shadow-sm bg-gray-50" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" class="text-emerald-900 font-bold text-xs uppercase tracking-wider" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg shadow-sm bg-gray-50"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <div>
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-800">Back</a>
            </div>
            <x-primary-button class="bg-emerald-900 hover:bg-emerald-800 text-white font-bold shadow-lg border-none rounded-full px-6 py-2">
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-auth-layout>