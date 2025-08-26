<div>
    <h3 class="font-heading text-2xl font-bold text-primary mb-6">{{ __('References') }}</h3>
    <div class="space-y-4 mb-6">
        @forelse ($references as $reference)
            <div class="p-4 border rounded-md flex justify-between items-center bg-gray-50">
                <div><p class="font-bold text-gray-800">{{ $reference->name }}</p></div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">{{ __("You haven't added any references yet.") }}</p>
        @endforelse
    </div>
    <h4 class="font-bold text-lg mb-4 pt-4 border-t">{{ __('Add New Reference') }}</h4>
    <form method="POST" action="{{ route('cv.storeReference', app()->getLocale()) }}">
        @csrf
        <div class="space-y-4">
            <div><x-input-label for="ref_name" :value="__('Full Name')" /><x-text-input id="ref_name" class="block mt-1 w-full" type="text" name="name" required /></div>
            <div><x-input-label for="ref_job_title" :value="__('Job Title')" /><x-text-input id="ref_job_title" class="block mt-1 w-full" type="text" name="job_title" /></div>
            <div><x-input-label for="ref_company" :value="__('Company')" /><x-text-input id="ref_company" class="block mt-1 w-full" type="text" name="company" /></div>
            <div><x-input-label for="ref_phone" :value="__('Phone')" /><x-text-input id="ref_phone" class="block mt-1 w-full" type="tel" name="phone" /></div>
            <div><x-input-label for="ref_email" :value="__('Email')" /><x-text-input id="ref_email" class="block mt-1 w-full" type="email" name="email" /></div>
            <div class="flex justify-end"><x-primary-button>{{ __('Add Reference') }}</x-primary-button></div>
        </div>
    </form>
    <div class="flex justify-between mt-8 pt-4 border-t">
        <a href="{{ route('cv.builder.certificates', app()->getLocale()) }}" class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">&larr; {{ __('Back') }}</a>
        <button class="bg-secondary text-white font-bold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">{{ __('Finish & Preview') }}</button>
    </div>
</div>