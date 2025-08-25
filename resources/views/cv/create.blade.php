<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-xl text-gray-800 leading-tight">
            {{ __('CV Builder') }}
        </h2>
    </x-slot>

    <div class="bg-gray-50" x-data="{
        currentStep: 'personal',
        completedSteps: [],
        personal: {
            photo: '{{ auth()->user()->profile && auth()->user()->profile->profile_image_path ? asset('storage/' . auth()->user()->profile->profile_image_path) : '' }}',
            first_name: { en: '{{ auth()->user()->profile->first_name['en'] ?? '' }}', ar: '{{ auth()->user()->profile->first_name['ar'] ?? '' }}' },
            last_name: { en: '{{ auth()->user()->profile->last_name['en'] ?? '' }}', ar: '{{ auth()->user()->profile->last_name['ar'] ?? '' }}' },
            job_title: '{{ $cv->job_title ?? '' }}',
            summary: `{!! e($cv->summary ?? '') !!}`,
            phone: '{{ (auth()->user()->profile->phone_numbers[0]['number'] ?? '') }}',
            email: '{{ auth()->user()->email }}',
            dob: '{{ auth()->user()->profile->date_of_birth ?? '' }}',
            gender: '{{ auth()->user()->profile->gender ?? 'male' }}',
            nationality: '{{ $countries->firstWhere('id', auth()->user()->profile->nationality_country_id)['name'] ?? '' }}',
            residence: '{{ $countries->firstWhere('id', auth()->user()->profile->residence_country_id)['name'] ?? '' }}'
        },
        experiences: {{ $workExperiences->toJson() }},
        education: {{ $education->toJson() }},
        skills: {{ $skills->toJson() }},
        languages: {{ $languages->toJson() }},
        projects: {{ $projects->toJson() }},
        certificates: {{ $certificates->toJson() }},
        references: {{ $references->toJson() }},
        cities: [],
        loadCities(countryId) {
            if (!countryId) { this.cities = []; return; }
            fetch(`/api/countries/${countryId}/cities`)
                .then(response => response.json())
                .then(data => { this.cities = data; });
        },
        nextStep(next) {
            if (!this.completedSteps.includes(this.currentStep)) {
                this.completedSteps.push(this.currentStep);
            }
            this.currentStep = next;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        isStepComplete(step) {
            return this.completedSteps.includes(step);
        },
        getStepClass(stepName) {
            if (this.currentStep === stepName) return 'text-primary';
            if (this.isStepComplete(stepName)) return 'text-secondary';
            return 'text-gray-400';
        },
        getStepBubbleClass(stepName) {
            if (this.currentStep === stepName) return 'bg-primary';
            if (this.isStepComplete(stepName)) return 'bg-secondary';
            return 'bg-gray-300';
        }
    }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- =============== Stepper Navigation =============== -->
                <div class="mb-8 p-4 bg-white rounded-lg shadow-md">
                    <div class="flex items-center text-sm sm:text-base">
                        <div @click="currentStep = 'personal'" :class="getStepClass('personal')" class="flex items-center cursor-pointer">
                            <div :class="getStepBubbleClass('personal')" class="rounded-full h-8 w-8 flex items-center justify-center text-white font-bold shrink-0">1</div>
                            <span class="ml-2 font-semibold hidden sm:inline">{{ __('Personal') }}</span>
                        </div>
                        <div class="flex-auto border-t-2 mx-2 sm:mx-4" :class="isStepComplete('personal') ? 'border-secondary' : 'border-gray-300'"></div>
                        
                        <div @click="currentStep = 'experience'" :class="getStepClass('experience')" class="flex items-center cursor-pointer">
                            <div :class="getStepBubbleClass('experience')" class="rounded-full h-8 w-8 flex items-center justify-center text-white font-bold shrink-0">2</div>
                            <span class="ml-2 font-semibold hidden sm:inline">{{ __('Experience') }}</span>
                        </div>
                        <div class="flex-auto border-t-2 mx-2 sm:mx-4" :class="isStepComplete('experience') ? 'border-secondary' : 'border-gray-300'"></div>
                        
                        <div @click="currentStep = 'education'" :class="getStepClass('education')" class="flex items-center cursor-pointer">
                            <div :class="getStepBubbleClass('education')" class="rounded-full h-8 w-8 flex items-center justify-center text-white font-bold shrink-0">3</div>
                            <span class="ml-2 font-semibold hidden sm:inline">{{ __('Education') }}</span>
                        </div>
                        {{-- Add more steps here --}}
                    </div>
                </div>

                <!-- =============== Forms Area =============== -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 md:p-8">
                        
                        <!-- Step 1: Personal Information Form -->
                        <div x-show="currentStep === 'personal'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
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
                            <div class="flex justify-end mt-8 pt-4 border-t">
                                <button @click.prevent="nextStep('experience')" class="bg-primary text-white font-bold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">
                                    {{ __('Save and Continue') }} &rarr;
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Work Experience Form -->
                        <div x-show="currentStep === 'experience'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
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
                                </div>
                            </form>
                            <div class="flex justify-between mt-8 pt-4 border-t">
                                <button @click.prevent="currentStep = 'personal'" class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">&larr; {{ __('Back') }}</button>
                                <button @click.prevent="nextStep('education')" class="bg-primary text-white font-bold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">{{ __('Save and Continue') }} &rarr;</button>
                            </div>
                        </div>
                        
                        <!-- Step 3: Education Form -->
                        <div x-show="currentStep === 'education'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
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
                                </div>
                            </form>
                            <div class="flex justify-between mt-8 pt-4 border-t">
                                <button @click.prevent="currentStep = 'experience'" class="bg-gray-200 text-gray-800 font-bold py-2 px-6 rounded-lg hover:bg-gray-300 transition">&larr; {{ __('Back') }}</button>
                                <button @click.prevent="nextStep('skills')" class="bg-primary text-white font-bold py-2 px-6 rounded-lg hover:bg-opacity-90 transition">{{ __('Save and Continue') }} &rarr;</button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- =============== Live Preview Area =============== -->
                <div class="mt-8">
                    <h3 class="font-heading text-2xl font-bold mb-4 text-gray-800">{{ __('Live Preview') }}</h3>
                    <div class="bg-white shadow-lg p-8 rounded-lg">
                        <div class="flex items-start space-x-8 rtl:space-x-reverse">
                            <!-- Profile Picture -->
                            <div class="shrink-0">
                                <div class="h-32 w-32 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                                    <template x-if="personal.photo">
                                        <img :src="personal.photo" class="h-32 w-32 object-cover" alt="Profile Photo">
                                    </template>
                                    <template x-if="!personal.photo">
                                        <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </template>
                                </div>
                            </div>
                            <!-- Main Info -->
                            <div class="flex-grow">
                                <h1 class="text-4xl font-heading font-bold text-primary" x-text="personal.first_name.en + ' ' + personal.last_name.en"></h1>
                                <h2 class="text-2xl font-heading font-bold text-right text-gray-600" x-text="personal.first_name.ar + ' ' + personal.last_name.ar" dir="rtl"></h2>
                                <p class="text-xl text-secondary mt-1" x-text="personal.job_title"></p>
                                <div class="text-sm text-gray-500 mt-4 border-t pt-2 flex flex-wrap gap-x-6 gap-y-2">
                                    <span><strong>Email:</strong> <span x-text="personal.email"></span></span>
                                    <span><strong>Phone:</strong> <span x-text="personal.phone"></span></span>
                                    <span><strong>DoB:</strong> <span x-text="personal.dob"></span></span>
                                    <span><strong>Nationality:</strong> <span x-text="personal.nationality"></span></span>
                                    <span><strong>Residence:</strong> <span x-text="personal.residence"></span></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- All other preview sections -->
                        <div class="mt-6">
                            <h3 class="text-lg font-heading font-bold border-b-2 border-gray-200 pb-1 mb-2 tracking-widest">{{ __('SUMMARY') }}</h3>
                            <p class="text-gray-700 text-sm whitespace-pre-wrap" x-text="personal.summary"></p>
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
                        <div class="mt-6">
                            <h3 class="text-lg font-heading font-bold border-b-2 border-gray-200 pb-1 mb-2 tracking-widest">{{ __('REFERENCES') }}</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <template x-for="ref in references" :key="ref.id">
                                    <div>
                                        <h4 class="font-bold text-primary" x-text="ref.name"></h4>
                                        <p class="text-sm" x-text="ref.job_title"></p>
                                        <p class="text-sm italic" x-text="ref.company"></p>
                                        <p class="text-sm text-gray-600" x-text="ref.phone"></p>
                                        <p class="text-sm text-gray-600" x-text="ref.email"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
