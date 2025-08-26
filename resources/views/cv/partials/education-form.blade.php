<div>
    <h3 class="font-heading text-2xl font-bold text-primary mb-6">{{ __('Education') }}</h3>
    <div class="space-y-4 mb-6">
        @forelse ($education as $edu)
            <div class="p-4 border rounded-md flex justify-between items-center bg-gray-50">
                <div><p class="font-bold text-gray-800">{{ $edu->degree }}</p><p class="text-sm text-gray-600">{{ $edu->institution }}</p></div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">{{ __("You haven't added any education yet.") }}</p>
        @endforelse
    </div>
    <h4 class="font-bold text-lg mb-4 pt-4 border-t">{{ __('Add New Qualification') }}</h4>
    <form method="POST" action="{{ route('cv.storeEducation', app()->getLocale()) }}">
        @csrf
        <div class="space-y-4">
            <div class="grid grid-cols-1 gap-4">
                <div><x-input-label for="degree" :value="__('Degree')" /><x-text-input id="degree" class="block mt-1 w-full" type="text" name="degree" required /></div>
                <div><x-input-label for="institution" :value="__('Institution')" /><x-text-input id="institution" class="block mt-1 w-full" type="text" name="institution" required /></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="start_date_edu" value="Start Date" />
                    <input type="month" id="start_date_edu" name="start_date" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <x-input-label for="end_date_edu" value="End Date" />
                    <input type="month" id="end_date_edu" name="end_date" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
            <div class="flex justify-end"><x-primary-button>{{ __('Add Qualification') }}</x-primary-button></div>
        </div>
    </form>
    <div class="flex justify-between mt-8 pt-4 border-t">
        <a href="{{ route('cv.builder.experience', app()->getLocale()) }}" class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">&larr; {{ __('Back') }}</a>
        <a href="{{ route('cv.builder.skills', app()->getLocale()) }}" class="bg-primary text-white font-bold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">{{ __('Save and Continue') }} &rarr;</a>
    </div>
</div>
