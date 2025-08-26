{{-- Add this style block at the top to ensure emoji fonts are loaded correctly --}}
<style>
    .font-emoji {
        font-family: "Noto Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Apple Color Emoji", sans-serif;
    }
</style>

<div>
    <h3 class="font-heading text-2xl font-bold text-primary mb-6">{{ __('Personal Information') }}</h3>
    <div class="space-y-6">
        <div class="space-y-4">
            <h4 class="font-bold text-sm text-gray-600">Profile Picture</h4>
            <form method="POST" action="{{ route('profile.updatePhoto', app()->getLocale()) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="flex items-center space-x-4">
                    <div class="shrink-0">
                        @if (auth()->user()->profile && auth()->user()->profile->profile_image_path)
                            <img class="h-16 w-16 object-cover rounded-full" src="{{ asset('storage/' . auth()->user()->profile->profile_image_path) }}" alt="Current profile photo" />
                        @else
                            <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow">
                        <input type="file" name="profile_photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20"/>
                    </div>
                    <x-primary-button>{{ __('Upload') }}</x-primary-button>
                </div>
            </form>

            <h4 class="font-bold text-sm text-gray-600 pt-4 border-t">Full Name</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-text-input placeholder="First Name (EN)" name="first_name_en" x-model="personal.first_name.en" />
                <x-text-input placeholder="Last Name (EN)" name="last_name_en" x-model="personal.last_name.en" />
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" dir="rtl">
                <x-text-input placeholder="الاسم الأول" name="first_name_ar" class="text-right" x-model="personal.first_name.ar" />
                <x-text-input placeholder="الكنية" name="last_name_ar" class="text-right" x-model="personal.last_name.ar" />
            </div>
            
            <h4 class="font-bold text-sm text-gray-600 pt-2 border-t">Contact Details</h4>
            <div>
                <x-input-label value="Phone Number" />
                <div class="flex">
                    <select class="border-gray-300 rounded-l-md shadow-sm font-emoji">
                        @foreach($countries as $country)
                            <option value="{{ $country['id'] }}">
                                {{ $country['flag_emoji'] }} {{ $country['country_code'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-text-input type="tel" class="rounded-l-none w-full" placeholder="999123456" x-model="personal.phone" />
                </div>
            </div>

            <h4 class="font-bold text-sm text-gray-600 pt-2 border-t">Personal Details</h4>
            <div>
                <x-input-label value="Nationality" />
                <select class="block mt-1 w-full border-gray-300 rounded-md shadow-sm font-emoji">
                    @foreach($countries as $country)
                        <option value="{{ $country['id'] }}">
                           {{ $country['flag_emoji'] }} {{ $country['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
             <div>
                <x-input-label value="Country of Residence" />
                <select @change="loadCities($event.target.value)" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm font-emoji">
                    <option value="">-- {{__('Select Country')}} --</option>
                    @foreach($countries as $country)
                        <option value="{{ $country['id'] }}">
                            {{ $country['flag_emoji'] }} {{ $country['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="flex justify-end mt-8 pt-4 border-t">
        <a href="{{ route('cv.builder.experience', app()->getLocale()) }}" class="bg-primary text-white font-bold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">
            {{ __('Save and Continue') }} &rarr;
        </a>
    </div>
</div>
