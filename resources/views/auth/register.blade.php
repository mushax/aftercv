<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row">
            
            <!-- Left Side: Branding & Image -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-primary text-white">
                <div class="transform transition-all duration-500">
                    <h1 class="font-heading text-4xl font-bold mb-4">Create Your Account</h1>
                    <p class="text-lg text-gray-200">
                        Join our community to build your professional CV and unlock a world of opportunities.
                    </p>
                    <div class="mt-8">
                        <img src="https://placehold.co/600x400/0D253F/FFFFFF?text=Join+AfterCV" alt="Branding Image" class="rounded-lg object-cover">
                    </div>
                </div>
            </div>

            <!-- Right Side: Registration Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12">
                <div class="w-full">
                    <div class="flex justify-center mb-6">
                        <x-application-logo class="h-12 w-auto" />
                    </div>
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Get started for free</h2>
                    <p class="text-center text-gray-600 mb-8">
                        Already have an account? 
                        <a href="{{ route('login', app()->getLocale()) }}" class="font-medium text-primary hover:underline">
                            Sign in
                        </a>
                    </p>

                    <form method="POST" action="{{ route('register', app()->getLocale()) }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-primary-button class="w-full flex justify-center">
                                {{ __('Register') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <!-- Social Logins Divider -->
                    <div class="mt-6 flex items-center">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="flex-shrink mx-4 text-gray-500 text-sm">Or sign up with</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>

                    <!-- Social Login Buttons -->
                    <div class="mt-6 grid grid-cols-1 gap-4">
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/><path d="M1 1h22v22H1z" fill="none"/>
                            </svg>
                            <span>Google</span>
                        </a>
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                               <path d="M22.23 0H1.77C.8 0 0 .77 0 1.72v20.56C0 23.23.8 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.72V1.72C24 .77 23.2 0 22.23 0zM7.27 20.46H3.75V9h3.52v11.46zM5.5 7.5c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm15.22 12.96h-3.52v-5.6c0-1.34-.02-3.07-1.87-3.07-1.87 0-2.16 1.46-2.16 2.97v5.7H9.67V9h3.38v1.54h.05c.47-.88 1.62-1.8 3.33-1.8 3.57 0 4.22 2.35 4.22 5.4v6.28z"/>
                            </svg>
                            <span>LinkedIn</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

