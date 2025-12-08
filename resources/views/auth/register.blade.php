<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-200 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit"
                class="inline-flex items-center px-4 py-3 ml-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Register') }}
            </button>
        </div>
        <div class="flex items-center justify-center mt-6">
            <div class="h-px bg-gray-300 w-full"></div>
            <span class="px-3 text-sm text-gray-500 font-medium">ATAU</span>
            <div class="h-px bg-gray-300 w-full"></div>
        </div>

        <div class="mt-6">
            <a href="{{ route('google.redirect') }}"
                class="w-full justify-center inline-flex items-center px-4 py-3 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 me-2" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M22.56 12.03c0-.76-.07-1.5-.2-2.2H12v4.18h5.71a4.9 4.9 0 01-2.13 3.3v2.7h3.48c2.04-1.88 3.23-4.66 3.23-7.98z"
                        fill="#4285F4" />
                    <path
                        d="M12 22.92c3.27 0 6.04-1.08 8.05-2.93l-3.48-2.7c-.96.65-2.2.98-3.48.98-2.67 0-4.94-1.78-5.74-4.16H2.7V18.5c2.02 1.94 4.87 3.42 8.5 3.42z"
                        fill="#34A853" />
                    <path
                        d="M6.26 13.91c-.19-.55-.29-1.15-.29-1.77s.1-1.22.29-1.77V7.63H2.7C1.96 9.17 1.5 10.78 1.5 12.44S1.96 15.71 2.7 17.25l3.56-3.34z"
                        fill="#FBBC05" />
                    <path
                        d="M12 5.92c1.78 0 3.3.62 4.54 1.79l3.08-3c-1.88-1.75-4.32-2.77-7.62-2.77C4.87 2.94 2.02 4.42.0 6.36l3.56 3.34c.8-2.38 3.07-4.16 5.74-4.16z"
                        fill="#EA4335" />
                </svg>
                {{ __('Daftar dengan Google') }}
            </a>
        </div>
    </form>
</x-guest-layout>
