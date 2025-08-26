<div>
    <h3 class="font-heading text-2xl font-bold text-primary mb-6">{{ __('Languages') }}</h3>
     <div class="space-y-4 mb-6">
        @forelse ($languages as $language)
            <div class="p-4 border rounded-md flex justify-between items-center bg-gray-50">
                <div><p class="font-bold text-gray-800">{{ $language->name }}</p><p class="text-sm text-gray-600">{{ $language->level }}</p></div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">{{ __("You haven't added any languages yet.") }}</p>
        @endforelse
    </div>
    <h4 class="font-bold text-lg mb-4 pt-4 border-t">{{ __('Add New Language') }}</h4>
    <form method="POST" action="{{ route('cv.storeLanguage', app()->getLocale()) }}">
        @csrf
        <div class="space-y-4">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <x-input-label for="language_name" :value="__('Language')" />
                    <x-text-input id="language_name" class="block mt-1 w-full" type="text" name="name" required />
                </div>
                <div>
                    <x-input-label for="language_level" :value="__('Proficiency Level')" />
                    <select name="level" id="language_level" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="Native">{{ __('Native') }}</option>
                        <option value="Fluent">{{ __('Fluent') }}</option>
                        <option value="Intermediate">{{ __('Intermediate') }}</option>
                        <option value="Beginner">{{ __('Beginner') }}</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end"><x-primary-button>{{ __('Add Language') }}</x-primary-button></div>
        </div>
    </form>
     <div class="flex justify-between mt-8 pt-4 border-t">
        <a href="{{ route('cv.builder.skills', app()->getLocale()) }}" class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">&larr; {{ __('Back') }}</a>
        <a href="{{ route('cv.builder.projects', app()->getLocale()) }}" class="bg-primary text-white font-bold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">{{ __('Save and Continue') }} &rarr;</a>
    </div>
</div>