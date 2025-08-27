<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center  px-4 py-12">
        <div class="w-full max-w-md bg-white p-6 sm:p-8 rounded-xl shadow-md text-center">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Verifikasi Email</h2>
            <p class="text-sm text-gray-600 mb-6">
                Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik tautan yang telah kami kirim. Jika tidak menerima email, kami akan mengirimkan yang baru.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm text-green-600 font-medium">
                    Tautan verifikasi baru telah dikirim ke email yang Anda daftarkan.
                </div>
            @endif

            <div class="flex flex-col sm:flex-row sm:justify-center gap-3">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                    @csrf
                    <x-primary-button class="w-full py-2 bg-blue-500 hover:bg-blue-600 rounded-md shadow-sm transition">
                        Kirim Ulang Email Verifikasi
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
