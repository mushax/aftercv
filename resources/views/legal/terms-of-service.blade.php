@section('title', __('Terms of Service'))
@section('description', __('Read the terms and conditions for using the AfterCV platform.'))

<x-guest-layout>
    <div class="p-8 max-w-4xl mx-auto">
        <h1 class="text-3xl font-heading font-bold text-primary mb-6">
            {{ __('Terms of Service') }}
        </h1>
        <div class="prose">
            <p>{{ __('Last updated: August 16, 2025') }}</p>
            
            <h2>1. {{ __('Agreement to Terms') }}</h2>
            <p>[{{ __('Placeholder for agreement terms. By using our service, you agree to these terms.') }}]</p>

            <h2>2. {{ __('User Accounts') }}</h2>
            <p>[{{ __('Placeholder for user account responsibilities. This section will detail user obligations regarding their accounts.') }}]</p>

            {{-- ... Add more placeholder sections as needed ... --}}
        </div>
    </div>
</x-guest-layout>