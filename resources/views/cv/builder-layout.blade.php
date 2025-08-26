<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-xl text-gray-800 leading-tight">
            {{ __('CV Builder') }}
        </h2>
    </x-slot>

    <div class="bg-gray-50" x-data="{
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
        }
    }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- =============== Stepper Navigation =============== -->
                <div class="mb-8 p-4 bg-white rounded-lg shadow-md overflow-x-auto">
                    <div class="flex items-center text-sm sm:text-base min-w-max">
                        @php
                            $steps = ['personal', 'experience', 'education', 'skills', 'languages', 'projects', 'certificates', 'references'];
                        @endphp

                        @foreach($steps as $index => $step)
                            <a href="{{ route('cv.builder.' . $step, app()->getLocale()) }}" 
                               class="flex items-center cursor-pointer {{ $currentStep === $step ? 'text-primary' : 'text-gray-400' }}">
                                <div class="rounded-full h-8 w-8 flex items-center justify-center text-white font-bold shrink-0 {{ $currentStep === $step ? 'bg-primary' : 'bg-gray-300' }}">
                                    {{ $index + 1 }}
                                </div>
                                <span class="ml-2 font-semibold hidden sm:inline">{{ __(ucfirst($step)) }}</span>
                            </a>
                            @if(!$loop->last)
                                <div class="flex-auto border-t-2 mx-2 sm:mx-4 border-gray-300"></div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- =============== Forms Area =============== -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 md:p-8">
                        @include('cv.partials.' . $currentStep . '-form')
                    </div>
                </div>

                <!-- =============== Live Preview Area =============== -->
                <div class="mt-8">
                    <h3 class="font-heading text-2xl font-bold mb-4 text-gray-800">{{ __('Live Preview') }}</h3>
                    <div class="bg-white shadow-lg p-8 rounded-lg">
                        <div class="flex items-start space-x-8 rtl:space-x-reverse">
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
