<div>
    <h3 class="font-heading text-2xl font-bold text-primary mb-6">{{ __('Skills') }}</h3>
    <div class="flex flex-wrap gap-2 mb-6">
        @forelse ($skills as $skill)
            <span class="bg-gray-200 text-gray-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-full flex items-center">
                {{ $skill->name }}
            </span>
        @empty
            <p class="text-gray-500 text-center py-4 w-full">{{ __("You haven't added any skills yet.") }}</p>
        @endforelse
    </div>
    <h4 class="font-bold text-lg mb-4 pt-4 border-t">{{ __('Add New Skill') }}</h4>
    <form method="POST" action="{{ route('cv.storeSkill', app()->getLocale()) }}" class="flex items-center gap-2">
        @csrf
        <x-text-input id="skill_name" class="block w-full" type="text" name="name" placeholder="{{ __('e.g., PHP, Laravel') }}" required />
        <x-primary-button>{{ __('Add') }}</x-primary-button>
    </form>
    <div class="flex justify-between mt-8 pt-4 border-t">
        <a href="{{ route('cv.builder.education', app()->getLocale()) }}" class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">&larr; {{ __('Back') }}</a>
        <a href="{{ route('cv.builder.languages', app()->getLocale()) }}" class="bg-primary text-white font-bold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">{{ __('Save and Continue') }} &rarr;</a>
    </div>
</div>