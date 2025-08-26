<div>
    <h3 class="font-heading text-2xl font-bold text-primary mb-6">{{ __('Projects') }}</h3>
    <div class="space-y-4 mb-6">
        @forelse ($projects as $project)
            <div class="p-4 border rounded-md flex justify-between items-center bg-gray-50">
                <div><p class="font-bold text-gray-800">{{ $project->name }}</p></div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">{{ __("You haven't added any projects yet.") }}</p>
        @endforelse
    </div>
    <h4 class="font-bold text-lg mb-4 pt-4 border-t">{{ __('Add New Project') }}</h4>
    <form method="POST" action="{{ route('cv.storeProject', app()->getLocale()) }}">
        @csrf
        <div class="space-y-4">
            <div><x-input-label for="project_name" :value="__('Project Name')" /><x-text-input id="project_name" class="block mt-1 w-full" type="text" name="name" required /></div>
            <div><x-input-label for="project_link" :value="__('Project Link (Optional)')" /><x-text-input id="project_link" class="block mt-1 w-full" type="url" name="link" /></div>
            <div><x-input-label for="project_description" :value="__('Description')" /><textarea id="project_description" name="description" class="border-gray-300 rounded-md shadow-sm block mt-1 w-full h-24"></textarea></div>
            <div class="flex justify-end"><x-primary-button>{{ __('Add Project') }}</x-primary-button></div>
        </div>
    </form>
    <div class="flex justify-between mt-8 pt-4 border-t">
        <a href="{{ route('cv.builder.languages', app()->getLocale()) }}" class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">&larr; {{ __('Back') }}</a>
        <a href="{{ route('cv.builder.certificates', app()->getLocale()) }}" class="bg-primary text-white font-bold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">{{ __('Save and Continue') }} &rarr;</a>
    </div>
</div>