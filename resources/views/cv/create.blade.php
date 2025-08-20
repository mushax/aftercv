<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-xl text-gray-800 leading-tight">
            {{ __('CV Builder') }}
        </h2>
    </x-slot>

    <div x-data="{
        personal: {
            first_name: { en: '{{ auth()->user()->profile->first_name['en'] ?? '' }}', ar: '{{ auth()->user()->profile->first_name['ar'] ?? '' }}' },
            father_name: { en: '{{ auth()->user()->profile->father_name['en'] ?? '' }}', ar: '{{ auth()->user()->profile->father_name['ar'] ?? '' }}' },
            last_name: { en: '{{ auth()->user()->profile->last_name['en'] ?? '' }}', ar: '{{ auth()->user()->profile->last_name['ar'] ?? '' }}' },
            job_title: '{{ $cv->job_title ?? '' }}',
            summary: `{!! e($cv->summary ?? '') !!}`,
            phone: '{{ (auth()->user()->profile->phone_numbers[0]['number'] ?? '') }}',
            email: '{{ auth()->user()->email }}'
        },
        experiences: {{ $workExperiences->toJson() }},
        education: {{ $education->toJson() }},
        skills: {{ $skills->toJson() }},
        languages: {{ $languages->toJson() }},
        openStep: 'personal',
        cities: [],
        loadCities(countryId) {
            if (!countryId) { this.cities = []; return; }
            const locale = '{{ app()->getLocale() }}';
            fetch(`/api/countries/${countryId}/cities?locale=${locale}`)
                .then(response => response.json())
                .then(data => { this.cities = data; });
        }
    }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- =============== Left Column: FORMS =============== -->
                    <div class="lg:col-span-1">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 md:p-8 space-y-6">
                                <!-- Accordion Item 1: Personal Information -->
                                <div class="border rounded-lg">
                                    <div @click="openStep = (openStep === 'personal' ? '' : 'personal')" class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 rounded-t-lg">
                                        <h3 class="font-heading text-lg font-bold text-primary">{{ __('Personal Information') }}</h3>
                                        <svg class="w-6 h-6 transform transition-transform" :class="{'rotate-180': openStep === 'personal'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="openStep === 'personal'" x-transition class="p-6 border-t">
                                        {{-- NOTE: The form action and logic will be fully built in a future step --}}
                                        <div class="space-y-4">
                                            <h4 class="font-bold text-sm text-gray-600">Full Name</h4>
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
                                                    <select class="border-gray-300 rounded-l-md shadow-sm">
                                                        @foreach($countries as $country)
                                                            <option value="{{ $country['id'] }}">{{ $country['flag_emoji'] }} {{ $country['country_code'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-text-input type="tel" class="rounded-l-none w-full" placeholder="999123456" x-model="personal.phone" />
                                                </div>
                                            </div>

                                            <h4 class="font-bold text-sm text-gray-600 pt-2 border-t">Personal Details</h4>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <div>
                                                    <x-input-label for="date_of_birth" value="Date of Birth" />
                                                    <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" />
                                                </div>
                                                <div>
                                                    <x-input-label for="gender" value="Gender" />
                                                    <select id="gender" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                                        <option value="male">{{__('Male')}}</option>
                                                        <option value="female">{{__('Female')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <x-input-label value="Nationality" />
                                                <select class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country['id'] }}">{{ $country['flag_emoji'] }} {{ $country['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                             <div>
                                                <x-input-label value="Country of Residence" />
                                                <select @change="loadCities($event.target.value)" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                                    <option value="">-- {{__('Select Country')}} --</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country['id'] }}">{{ $country['flag_emoji'] }} {{ $country['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                             <div>
                                                <x-input-label value="City of Residence" />
                                                <select class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                                    <template x-if="cities.length === 0"><option disabled>{{__('Select a country first')}}</option></template>
                                                    <template x-for="city in cities" :key="city.id">
                                                        <option :value="city.id" x-text="city.name"></option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Accordion Item 2: Work Experience -->
                                <div class="border rounded-lg">
                                    <div @click="openStep = (openStep === 'experience' ? '' : 'experience')" class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 rounded-t-lg">
                                        <h3 class="font-heading text-lg font-bold text-primary">{{ __('Work Experience') }}</h3>
                                        <svg class="w-6 h-6 transform transition-transform" :class="{'rotate-180': openStep === 'experience'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="openStep === 'experience'" x-transition class="p-6 border-t">
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
                                    </div>
                                </div>
                                
                                <!-- Accordion Item 3: Education -->
                                <div class="border rounded-lg">
                                    <div @click="openStep = (openStep === 'education' ? '' : 'education')" class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 rounded-t-lg">
                                        <h3 class="font-heading text-lg font-bold text-primary">{{ __('Education') }}</h3>
                                        <svg class="w-6 h-6 transform transition-transform" :class="{'rotate-180': openStep === 'education'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="openStep === 'education'" x-transition class="p-6 border-t">
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
                                    </div>
                                </div>

                                <!-- Accordion Item 4: Skills -->
                                <div class="border rounded-lg">
                                    <div @click="openStep = (openStep === 'skills' ? '' : 'skills')" class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 rounded-t-lg">
                                        <h3 class="font-heading text-lg font-bold text-primary">{{ __('Skills') }}</h3>
                                        <svg class="w-6 h-6 transform transition-transform" :class="{'rotate-180': openStep === 'skills'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="openStep === 'skills'" x-transition class="p-6 border-t">
                                        <div class="flex flex-wrap gap-2 mb-6">
                                            @forelse ($skills as $skill)
                                                <span class="bg-gray-200 text-gray-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-full flex items-center">
                                                    {{ $skill->name }}
                                                </span>
                                            @empty
                                                <p class="text-gray-500 text-center py-4 w-full">{{ __("You haven't added any skills yet.") }}</p>
                                            @endforelse
                                        </div>
                                        <form method="POST" action="{{ route('cv.storeSkill', app()->getLocale()) }}" class="flex items-center gap-2 pt-4 border-t">
                                            @csrf
                                            <x-text-input id="skill_name" class="block w-full" type="text" name="name" placeholder="{{ __('e.g., PHP, Laravel') }}" required />
                                            <x-primary-button>{{ __('Add') }}</x-primary-button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Accordion Item 5: Languages -->
                                <div class="border rounded-lg">
                                    <div @click="openStep = (openStep === 'languages' ? '' : 'languages')" class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 rounded-t-lg">
                                        <h3 class="font-heading text-lg font-bold text-primary">{{ __('Languages') }}</h3>
                                        <svg class="w-6 h-6 transform transition-transform" :class="{'rotate-180': openStep === 'languages'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="openStep === 'languages'" x-transition class="p-6 border-t">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- =============== Right Column: CV PREVIEW =============== -->
                    <div class="lg:col-span-2">
                        <div class="sticky top-8">
                            <div class="bg-white shadow-lg p-8">
                                <div class="text-center border-b-2 pb-4">
                                    <h1 class="text-3xl font-heading font-bold" x-text="personal.first_name.en + ' ' + personal.last_name.en"></h1>
                                    <h2 class="text-xl font-heading font-bold text-right" x-text="personal.first_name.ar + ' ' + personal.last_name.ar" dir="rtl"></h2>
                                </div>
                                <div class="text-center text-sm text-gray-600 mt-4 flex justify-center items-center flex-wrap gap-x-4">
                                    <span x-text="personal.email"></span><span>|</span><span x-text="personal.phone"></span>
                                </div>
                                <div class="mt-6">
                                    <h3 class="text-lg font-heading font-bold border-b-2 border-gray-200 pb-1 mb-2 tracking-widest">{{ __('WORK EXPERIENCE') }}</h3>
                                    <template x-for="exp in experiences" :key="exp.id">
                                        <div class="mb-4">
                                            <div class="flex justify-between items-baseline">
                                                <h4 class="font-bold text-primary" x-text="exp.job_title"></h4>
                                                <p class="text-sm text-gray-600" x-text="exp.start_date + ' - ' + (exp.end_date || 'Present')"></p>
                                            </div>
                                            <p class="text-sm italic" x-text="exp.company"></p>
                                        </div>
                                    </template>
                                </div>
                                <div class="mt-6">
                                    <h3 class="text-lg font-heading font-bold border-b-2 border-gray-200 pb-1 mb-2 tracking-widest">{{ __('EDUCATION') }}</h3>
                                    <template x-for="edu in education" :key="edu.id">
                                        <div class="mb-4">
                                            <div class="flex justify-between items-baseline">
                                                <h4 class="font-bold text-primary" x-text="edu.degree"></h4>
                                                <p class="text-sm text-gray-600" x-text="edu.start_date + ' - ' + (edu.end_date || 'Present')"></p>
                                            </div>
                                            <p class="text-sm italic" x-text="edu.institution"></p>
                                        </div>
                                    </template>
                                </div>
                                <div class="grid grid-cols-2 gap-6 mt-6">
                                    <div>
                                        <h3 class="text-lg font-heading font-bold border-b-2 border-gray-200 pb-1 mb-2 tracking-widest">{{ __('SKILLS') }}</h3>
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="skill in skills" :key="skill.id">
                                                <span class="bg-gray-200 text-gray-800 text-sm font-medium px-3 py-1 rounded-full" x-text="skill.name"></span>
                                            </template>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-heading font-bold border-b-2 border-gray-200 pb-1 mb-2 tracking-widest">{{ __('LANGUAGES') }}</h3>
                                        <div class="space-y-1">
                                            <template x-for="lang in languages" :key="lang.id">
                                                <div class="flex justify-between text-sm">
                                                    <p class="font-medium" x-text="lang.name"></p>
                                                    <p class="text-gray-600" x-text="lang.level"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
