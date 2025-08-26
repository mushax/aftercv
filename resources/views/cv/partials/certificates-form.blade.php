<div>
    <h3 class="font-heading text-2xl font-bold text-primary mb-6">{{ __('Certificates') }}</h3>
    <div class="space-y-4 mb-6">
        @forelse ($certificates as $certificate)
            <div class="p-4 border rounded-md flex justify-between items-center bg-gray-50">
                <div><p class="font-bold text-gray-800">{{ $certificate->name }}</p></div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">{{ __("You haven't added any certificates yet.") }}</p>
        @endforelse
    </div>
    <h4 class="font-bold text-lg mb-4 pt-4 border-t">{{ __('Add New Certificate') }}</h4>
    <form method="POST" action="{{ route('cv.storeCertificate', app()->getLocale()) }}">
        @csrf
        <div class="space-y-4">
            <div><x-input-label for="cert_name" :value="__('Certificate Name')" /><x-text-input id="cert_name" class="block mt-1 w-full" type="text" name="name" required /></div>
            <div><x-input-label for="cert_org" :value="__('Issuing Organization')" /><x-text-input id="cert_org" class="block mt-1 w-full" type="text" name="issuing_organization" required /></div>
            <div>
                <x-input-label for="issue_date_cert" value="Issue Date" />
                <input type="month" id="issue_date_cert" name="issue_date" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div class="flex justify-end"><x-primary-button>{{ __('Add Certificate') }}</x-primary-button></div>
        </div>
    </form>
    <div class="flex justify-between mt-8 pt-4 border-t">
        <a href="{{ route('cv.builder.projects', app()->getLocale()) }}" class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">&larr; {{ __('Back') }}</a>
        <a href="{{ route('cv.builder.references', app()->getLocale()) }}" class="bg-primary text-white font-bold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">{{ __('Save and Continue') }} &rarr;</a>
    </div>
</div>