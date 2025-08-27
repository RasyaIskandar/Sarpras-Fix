<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-sm bg-white p-6 sm:p-8 rounded-xl shadow-md">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Reset Password</h2>
                <p class="text-sm text-gray-500 mt-1">Masukkan email dan password baru Anda</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 text-sm"/>
                    <x-text-input id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400 text-sm"
                                  type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-600" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password Baru')" class="text-gray-700 text-sm"/>
                    <x-text-input id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400 text-sm"
                                  type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-600" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-700 text-sm"/>
                    <x-text-input id="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400 text-sm"
                                  type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-600" />
                </div>

                <!-- Submit Button -->
                <div>
                    <x-primary-button class="w-full py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-md shadow-sm transition">
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
