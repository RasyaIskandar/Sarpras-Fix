<x-guest-layout>
    <div class="w-full h-full flex relative overflow-hidden rounded-3xl shadow-lg bg-no-repeat bg-cover bg-neutral-100"
        style="background-image: url('/images/wave-7.svg');">

        <!-- Decorative circles -->
        <div class="absolute inset-0">
            <div class="absolute w-64 h-64 bg-blue-800 rounded-full opacity-20 top-10 left-10"></div>
            <div class="absolute w-40 h-40 bg-blue-400 rounded-full opacity-20 bottom-20 right-20"></div>
        </div>

        <!-- Left Section (Image & Logo) -->
        <div class="hidden md:flex md:w-1/2 relative">
            <div class="flex flex-col items-center justify-center w-full z-10 relative">
                <div class="absolute inset-0 bg-cover bg-center opacity-20"
                    style="background-image: url('/images/blob-3.svg');"></div>
                <img src="/images/Desian-Web.jpg" alt="SMK Pesat IT XPro" class="w-80 rounded-3xl relative z-10">
            </div>
            <div class="absolute top-8 left-8 z-10">
                <img src="/images/logo.png" alt="Logo" class="w-24">
            </div>
        </div>

        <!-- Right Section (Forgot Password Form) -->
        <div class="flex w-full md:w-1/2 items-center justify-center px-6 py-10 relative z-10">
            <div class="w-full max-w-md">
                <!-- Title -->
                <h2 class="text-3xl font-bold mb-6 text-black sm:text-neutral-200 text-center">Lupa Password</h2>

                <!-- Description -->
                <p class="mb-6 text-sm text-black sm:text-neutral-200 text-center">
                    Lupa kata sandi? Tidak masalah. Masukkan email Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm mb-1 text-black sm:text-neutral-200">Email</label>
                        <input id="email" type="email" name="email"
                            class="w-full px-4 py-3 rounded-lg text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-900"
                            placeholder="Your Email" value="{{ old('email') }}" required autofocus>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Button -->
                    <x-primary-button
                        class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 rounded-lg transition">
                        {{ __('Kirim Tautan Atur Ulang Kata Sandi') }}
                    </x-primary-button>

                    <!-- Back to Login -->
                    <p class="text-center text-sm mt-4 text-black sm:text-neutral-200">
                        <span class="text-black">Ingat kata sandi?</span> 
                        <a href="{{ route('login') }}" class="text-blue-300 hover:underline">Login disini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>