<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                        aria-label="Toggle password visibility"
                        onclick="(
                            function(e){
                                e.preventDefault(); 
                                const input = document.getElementById('password'); 
                                const show = input.type==='password'; input.type = show ? 'text' : 'password'; 
                                const eye = document.getElementById('pass-eye'); 
                                const eyeOff = document.getElementById('pass-eye-off'); 
                                if(eye && eyeOff){ 
                                    eye.classList.toggle('hidden', !show); 
                                    eyeOff.classList.toggle('hidden', show); 
                                } 
                            })(event);">

                    <svg id="pass-eye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    
                    <svg id="pass-eye-off" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.223-3.477" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.11 6.11A9.953 9.953 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.99 9.99 0 01-1.631 3.041" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.88 9.88a3 3 0 004.24 4.24" />
                    </svg>
                </button>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
