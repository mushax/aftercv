<div>
    <h3 class="font-heading text-2xl font-bold text-primary mb-6">{{ __('Work Experience') }}</h3>
    <div class="space-y-4 mb-6">
        @forelse ($workExperiences as $experience)
            <div class="p-4 border rounded-md flex justify-between items-center bg-gray-50">
                <div><p class="font-bold text-gray-800">{{ $experience->job_title }}</p><p class="text-sm text-gray-600">{{ $experience->company }}</p></div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">{{ __("You haven't added any work experience yet.") }}</p>
        @endforelse
    </div>
    <h4 class="font-bold text-lg mb-4 pt-4 border-t">{{ __('Add New Experience') }}</h4>
    <form method="POST" action="{{ route('cv.storeWorkExperience', app()->getLocale()) }}">
        @csrf
        <div class="space-y-4">
            <div class="grid grid-cols-1 gap-4">
                <div><x-input-label for="job_title_exp" :value="__('Job Title')" /><x-text-input id="job_title_exp" class="block mt-1 w-full" type="text" name="job_title" required /></div>
                <div><x-input-label for="company" :value="__('Company')" /><x-text-input id="company" class="block mt-1 w-full" type="text" name="company" required /></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="start_date_exp" value="Start Date" />
                    <input type="month" id="start_date_exp" name="start_date" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <x-input-label for="end_date_exp" value="End Date" />
                    <input type="month" id="end_date_exp" name="end_date" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
            <div class="flex justify-end"><x-primary-button>{{ __('Add Experience') }}</x-primary-button></div>
        </div>
    </form>
    <div class="flex justify-between mt-8 pt-4 border-t">
        <a href="{{ route('cv.builder.personal', app()->getLocale()) }}" class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">&larr; {{ __('Back') }}</a>
        <a href="{{ route('cv.builder.education', app()->getLocale()) }}" class="bg-primary text-white font-bold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">{{ __('Save and Continue') }} &rarr;</a>
    </div>
</div>