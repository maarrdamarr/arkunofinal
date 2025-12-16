<x-auth-layout>
    <div class="mb-6 text-center">
        <h2 class="font-serif text-2xl font-bold text-emerald-950">Recovery</h2>
    </div>

    <div class="mb-4 text-sm text-gray-600 leading-relaxed">
        {{ __('Lupa password Anda? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan pengaturan ulang password.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="flex items-center gap-3">
            <div class="flex-1">
                <x-input-label for="email" :value="__('Email')" class="text-emerald-900 font-bold text-xs uppercase tracking-wider" />
                <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500 rounded-lg shadow-sm bg-gray-50" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-6">
                <a href="https://wa.me/6288210690054" target="_blank" rel="noopener" class="inline-flex items-center px-4 py-2 bg-emerald-900 hover:bg-emerald-800 text-white text-sm font-semibold rounded-lg shadow">
                    <i class="fab fa-whatsapp mr-2"></i> Hubungi Admin
                </a>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <div>
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-800">Back</a>
            </div>
            <x-primary-button class="bg-emerald-900 hover:bg-emerald-800 text-white font-bold shadow-lg border-none rounded-full px-6 py-2">
                {{ __('Kirim Tautan Reset') }}
            </x-primary-button>
        </div>
    </form>
    <div class="mt-4 text-sm text-gray-700">
        Jika mengalami kendala dalam mereset password, silakan hubungi admin melalui WhatsApp:
        <a href="https://wa.me/6288210690054" target="_blank" rel="noopener" class="font-semibold text-emerald-800">wa.me/6288210690054</a>
    </div>
</x-auth-layout>