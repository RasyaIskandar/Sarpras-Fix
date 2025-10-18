<x-guest-layout>
    <div class="w-full h-full flex relative overflow-hidden rounded-3xl shadow-lg bg-no-repeat bg-cover bg-neutral-100"
        style="background-image: url('/images/wave-7.svg');">
        <!-- Decorative circles (background effect) -->
        <div class="absolute inset-0">
            <div class="absolute w-40 h-40 bg-blue-400 rounded-full opacity-20 bottom-20 right-20"></div>
        </div>

        <!-- Left Section with Curve -->
        <div class="hidden md:flex md:w-1/2 relative">

            <!-- Illustration -->
            <div class="flex flex-col items-center justify-center w-full z-10 relative">
                <div class="absolute inset-0 bg-cover bg-center opacity-20"
                    style="background-image: url('/images/blob-3.svg');"></div>
                <img src="/images/Desian-Web.jpg" alt="SMK Pesat IT XPro" class="w-80 rounded-3xl relative z-10">
            </div>

            <!-- Logo -->
            <div class="absolute top-8 left-8 z-10">
                <img src="/images/logo.png" alt="Logo" class="w-24">
            </div>
        </div>

        <!-- Right Section (Login Form) -->
        <div
            class="flex w-full md:w-1/2 text-black sm:text-neutral-200 items-center justify-center px-6 py-10 relative z-10">
            <div class="w-full max-w-md">
                <h2 class="text-3xl text-center font-bold mb-8">Login</h2>

                <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Username -->
                    <div>
                        <label for="email" class="block text-sm mb-1">Email</label>
                        <input id="email" type="email" name="email"
                            class="w-full px-4 py-3 rounded-lg text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300"
                            placeholder="Enter your Email" value="{{ old('email') }}" required autofocus>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm mb-1">Password</label>
                        <input id="password" type="password" name="password"
                            class="w-full px-4 py-3 rounded-lg text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300"
                            placeholder="Enter your password" required>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Forgot Password -->
                    <div class="text-right">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-blue-300 text-sm hover:underline">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <!-- Button -->
                    <x-primary-button
                        class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 rounded-lg transition">
                        {{ __('Login') }}
                    </x-primary-button>

                    <!-- Register Link -->
                    <p class="text-center text-sm mt-4">
                        <span class="text-black">Belum punya akun?</span>
                        <a href="{{ route('register') }}" class="text-blue-300 hover:underline">Buat disini!</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
