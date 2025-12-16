<x-auth-layout>
    <div class="mb-6 text-center">
        <h2 class="font-serif text-2xl font-bold text-emerald-950">Verify Identity</h2>
    </div>

    <div class="mb-4 text-sm text-gray-600 leading-relaxed">
        {{ __('Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan kepada Anda? Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan yang lain.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-700 bg-green-50 p-3 rounded-lg border border-green-200">
            {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
        </div>
    @endif

    <div class="mt-6">
        <div class="flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="bg-emerald-900 hover:bg-emerald-800 text-white font-bold rounded-full px-6 border-none shadow-md">
                    {{ __('Kirim Ulang Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="underline text-sm text-gray-500 hover:text-red-600 rounded-md focus:outline-none">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>

        <div class="mt-4">
            <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-800">Back</a>
        </div>
    </div>
</x-guest-layout>