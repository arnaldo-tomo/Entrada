<x-guest-layout>
    <!-- Include Heroicons for icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/heroicons@2.3.0/outline.css">

    <!-- Session Status -->
    <x-auth-session-status class="mb-6 text-center text-gray-600" :status="session('status')" />

    <div class="max-w-md p-8 mx-auto rounded-lg ">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
                </a>
            </div>
        <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">{{ __('Emissão e gestão de cartões.') }}</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="relative mb-6">
                <x-input-label for="email" :value="__('Email')" class="font-medium text-gray-700" />
                <div class="relative">
                    <x-text-input id="email" class="block w-full pl-10 mt-1 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <svg class="absolute w-5 h-5 text-gray-400 transform -translate-y-1/2 left-3 top-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div class="relative mb-6">
                <x-input-label for="password" :value="__('Password')" class="font-medium text-gray-700" />
                <div class="relative">
                    <x-text-input id="password" class="block w-full pl-10 mt-1 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" type="password" name="password" required autocomplete="current-password" />
                    <svg class="absolute w-5 h-5 text-gray-400 transform -translate-y-1/2 left-3 top-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.104-.896-2-2-2s-2 .896-2 2c0 .736.398 1.378 1 1.732V15a1 1 0 001 1h2a1 1 0 001-1v-2.268c.602-.354 1-.996 1-1.732zm7 1c0-4.418-3.582-8-8-8s-8 3.582-8 8 3.582 8 8 8 8-3.582 8-8z"></path>
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-6">
                <input id="remember_me" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500" name="remember">
                <label for="remember_me" class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-indigo-600 underline hover:text-indigo-800" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="px-4 py-2 font-semibold text-white transition duration-200 bg-indigo-600 rounded-md hover:bg-indigo-700">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
