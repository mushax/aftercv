@section('title', __('Privacy Policy'))
@section('description', __('Learn about how AfterCV handles your data and respects your privacy.'))

<x-guest-layout>
    <div class="p-8 max-w-4xl mx-auto">
        <h1 class="text-3xl font-heading font-bold text-primary mb-6">
            {{ __('Privacy Policy') }}
        </h1>
        <div class="prose">
            <p>{{ __('Last updated: August 16, 2025') }}</p>
            
            <h2>1. {{ __('Introduction') }}</h2>
            <p>[{{ __('Placeholder for introduction text. This section will detail our commitment to user privacy.') }}]</p>

            <h2>2. {{ __('Data We Collect') }}</h2>
            <p>[{{ __('Placeholder for data collection details. This section will list the types of personal and non-personal information we collect from users.') }}]</p>

            {{-- ... Add more placeholder sections as needed ... --}}
        </div>
    </div>
</x-guest-layout>