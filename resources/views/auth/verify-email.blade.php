<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row">
            
            <!-- Left Side: Branding & Image -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-primary text-white">
                <div class="transform transition-all duration-500">
                    <h1 class="font-heading text-4xl font-bold mb-4">Almost there!</h1>
                    <p class="text-lg text-gray-200">
                        We've sent a link to your email address. Please click the link to verify your account and get started.
                    </p>
                    <div class="mt-8">
                        <img src="https://placehold.co/600x400/0D253F/FFFFFF?text=Verify" alt="Branding Image" class="rounded-lg object-cover">
                    </div>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                <div class="w-full">
                    <div class="flex justify-center mb-6">
                        <x-application-logo class="h-12 w-auto" />
                    </div>
                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Verify Your Email</h2>
                    
                    <div class="mb-4 text-sm text-gray-600 text-center">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-center text-green-600">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <div class="mt-6 flex items-center justify-between">
                        <form method="POST" action="{{ route('verification.send', app()->getLocale()) }}">
                            @csrf
                            <x-primary-button>
                                {{ __('Resend Verification Email') }}
                            </x-primary-button>
                        </form>

                        <form method="POST" action="{{ route('logout', app()->getLocale()) }}">
                            @csrf
                            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
