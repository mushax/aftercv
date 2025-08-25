<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row">
            
            <!-- Left Side: Branding & Image -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-primary text-white">
                <div class="transform transition-all duration-500">
                    <h1 class="font-heading text-4xl font-bold mb-4">Security Check</h1>
                    <p class="text-lg text-gray-200">
                        This is a secure area of the application. Please confirm your password before continuing.
                    </p>
                    <div class="mt-8">
                        <img src="https://placehold.co/600x400/0D253F/FFFFFF?text=Secure" alt="Branding Image" class="rounded-lg object-cover">
                    </div>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12">
                <div class="w-full">
                    <div class="flex justify-center mb-6">
                        <x-application-logo class="h-12 w-auto" />
                    </div>
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Confirm Your Password</h2>
                    <p class="text-center text-gray-600 mb-8">
                        For your security, please re-enter your password to continue.
                    </p>

                    <form method="POST" action="{{ route('password.confirm', app()->getLocale()) }}">
                        @csrf

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block mt-1 w-full"
                                          type="password"
                                          name="password"
                                          required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-primary-button class="w-full flex justify-center">
                                {{ __('Confirm') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
