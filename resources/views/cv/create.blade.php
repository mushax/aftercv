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
        projects: {{ $projects->toJson() }},
        certificates: {{ $certificates->toJson() }},
        references: {{ $references->toJson() }},
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

                                <!-- Accordion Item 6: Projects -->
                                <div class="border rounded-lg">
                                    <div @click="openStep = (openStep === 'projects' ? '' : 'projects')" class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 rounded-t-lg">
                                        <h3 class="font-heading text-lg font-bold text-primary">{{ __('Projects') }}</h3>
                                        <svg class="w-6 h-6 transform transition-transform" :class="{'rotate-180': openStep === 'projects'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="openStep === 'projects'" x-transition class="p-6 border-t">
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
                                    </div>
                                </div>
                                
                                <!-- Accordion Item 7: Certificates -->
                                <div class="border rounded-lg">
                                    <div @click="openStep = (openStep === 'certificates' ? '' : 'certificates')" class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 rounded-t-lg">
                                        <h3 class="font-heading text-lg font-bold text-primary">{{ __('Certificates') }}</h3>
                                        <svg class="w-6 h-6 transform transition-transform" :class="{'rotate-180': openStep === 'certificates'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="openStep === 'certificates'" x-transition class="p-6 border-t">
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
                                    </div>
                                </div>

                                <!-- Accordion Item 8: References -->
                                <div class="border rounded-lg">
                                    <div @click="openStep = (openStep === 'references' ? '' : 'references')" class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 rounded-t-lg">
                                        <h3 class="font-heading text-lg font-bold text-primary">{{ __('References') }}</h3>
                                        <svg class="w-6 h-6 transform transition-transform" :class="{'rotate-180': openStep === 'references'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="openStep === 'references'" x-transition class="p-6 border-t">
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
                                <div class="mt-6">
                                    <h3 class="text-lg font-heading font-bold border-b-2 border-gray-200 pb-1 mb-2 tracking-widest">{{ __('PROJECTS') }}</h3>
                                    <template x-for="proj in projects" :key="proj.id">
                                        <div class="mb-4">
                                            <div class="flex justify-between items-baseline">
                                                <h4 class="font-bold text-primary" x-text="proj.name"></h4>
                                                <a :href="proj.link" target="_blank" class="text-sm text-blue-500 hover:underline" x-show="proj.link">View Project</a>
                                            </div>
                                            <p class="text-sm text-gray-700 mt-1" x-text="proj.description"></p>
                                        </div>
                                    </template>
                                </div>
                                <div class="mt-6">
                                    <h3 class="text-lg font-heading font-bold border-b-2 border-gray-200 pb-1 mb-2 tracking-widest">{{ __('CERTIFICATES') }}</h3>
                                    <template x-for="cert in certificates" :key="cert.id">
                                        <div class="mb-4">
                                            <div class="flex justify-between items-baseline">
                                                <h4 class="font-bold text-primary" x-text="cert.name"></h4>
                                                <p class="text-sm text-gray-600" x-text="cert.issue_date"></p>
                                            </div>
                                            <p class="text-sm italic" x-text="cert.issuing_organization"></p>
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
