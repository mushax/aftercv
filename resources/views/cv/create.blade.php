<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading text-xl text-gray-800 leading-tight">
            {{ __('CV Builder') }}
        </h2>
    </x-slot>

    {{-- We wrap the entire page in an Alpine.js component to manage the live data --}}
    <div x-data='{
        personal: {
            name: "{{ auth()->user()->name }}",
            job_title: `{!! old('job_title', e(auth()->user()->profile->job_title ?? '')) !!}`,
            phone: `{!! old('phone_number', e(auth()->user()->profile->phone_number ?? '')) !!}`,
            email: "{{ auth()->user()->email }}",
            address: `{!! old('address', e(auth()->user()->profile->address ?? '')) !!}`,
            summary: `{!! old('summary', e(auth()->user()->profile->summary ?? '')) !!}`
        },
        experiences: {{ $workExperiences->toJson() }},
        openStep: "personal"
    }'>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Main Grid Layout: 1/3 for the form, 2/3 for the preview --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-1">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 md:p-8 space-y-6">

                                <div class="border rounded-lg">
                                    <div @click="openStep = (openStep === 'personal' ? '' : 'personal')" class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 rounded-t-lg">
                                        <h3 class="font-heading text-lg font-bold text-primary">{{ __('Step 1: Personal Information') }}</h3>
                                        <svg class="w-6 h-6 transform transition-transform" :class="{'rotate-180': openStep === 'personal'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="openStep === 'personal'" x-transition class="p-6 border-t">
                                        <form method="POST" action="{{ route('cv.storePersonalInfo', app()->getLocale()) }}">
                                            @csrf
                                            <div class="space-y-6">
                                                <div>
                                                    <x-input-label for="job_title" :value="__('Job Title')" />
                                                    <x-text-input id="job_title" class="block mt-1 w-full" type="text" name="job_title" x-model="personal.job_title" required />
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div>
                                                        <x-input-label for="phone_number" :value="__('Phone Number')" />
                                                        <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" x-model="personal.phone" />
                                                    </div>
                                                    <div>
                                                        <x-input-label for="address" :value="__('Address')" />
                                                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" x-model="personal.address"/>
                                                    </div>
                                                </div>
                                                <div>
                                                    <x-input-label for="summary" :value="__('Professional Summary')" />
                                                    <textarea id="summary" name="summary" x-model="personal.summary" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full h-32"></textarea>
                                                </div>
                                                <div class="flex items-center justify-end pt-4 border-t">
                                                    <x-primary-button>{{ __('Save Personal Info') }}</x-primary-button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="border rounded-lg">
                                    <div @click="openStep = (openStep === 'experience' ? '' : 'experience')" class="p-4 cursor-pointer flex justify-between items-center bg-gray-50 rounded-t-lg">
                                        <h3 class="font-heading text-lg font-bold text-primary">{{ __('Step 2: Work Experience') }}</h3>
                                        <svg class="w-6 h-6 transform transition-transform" :class="{'rotate-180': openStep === 'experience'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <div x-show="openStep === 'experience'" x-transition class="p-6 border-t">
                                        <div class="space-y-4 mb-6">
                                            @forelse ($workExperiences as $experience)
                                                <div class="p-4 border rounded-md flex justify-between items-center bg-gray-50">
                                                    <div><p class="font-bold text-gray-800">{{ $experience->job_title }}</p><p class="text-sm text-gray-600">{{ $experience->company }}</p></div>
                                                    <div class="flex space-x-2 rtl:space-x-reverse"><button class="text-blue-500 hover:underline text-sm">{{ __('Edit') }}</button><button class="text-red-500 hover:underline text-sm">{{ __('Delete') }}</button></div>
                                                </div>
                                            @empty
                                                <p class="text-gray-500 text-center py-4">{{ __("You haven't added any work experience yet.") }}</p>
                                            @endforelse
                                        </div>
                                        <h4 class="font-bold text-lg mb-4 pt-4 border-t">{{ __('Add New Experience') }}</h4>
                                        <form method="POST" action="{{ route('cv.storeWorkExperience', app()->getLocale()) }}">
                                            @csrf
                                            <div class="space-y-4">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div><x-input-label for="job_title_exp" :value="__('Job Title')" /><x-text-input id="job_title_exp" class="block mt-1 w-full" type="text" name="job_title" required /></div>
                                                    <div><x-input-label for="company" :value="__('Company')" /><x-text-input id="company" class="block mt-1 w-full" type="text" name="company" required /></div>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div><x-input-label for="start_date" :value="__('Start Date')" /><x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" required /></div>
                                                    <div><x-input-label for="end_date" :value="__('End Date (leave empty if current)')" /><x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" /></div>
                                                </div>
                                                <div><x-input-label for="description" :value="__('Description')" /><textarea id="description" name="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full h-24"></textarea></div>
                                                <div class="flex justify-end"><x-primary-button>{{ __('Add Experience') }}</x-primary-button></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="sticky top-8">
                            <div class="bg-white shadow-lg p-8 A4-aspect-ratio">
                                {{-- CV Header --}}
                                <div class="text-center border-b-2 pb-4">
                                    <h1 class="text-3xl font-heading font-bold" x-text="personal.name"></h1>
                                    <h2 class="text-xl font-medium text-secondary mt-1" x-text="personal.job_title"></h2>
                                </div>
                                
                                {{-- Contact Info --}}
                                <div class="text-center text-sm text-gray-600 mt-4 flex justify-center items-center flex-wrap gap-x-4">
                                    <span x-text="personal.email"></span><span>|</span><span x-text="personal.phone"></span><span>|</span><span x-text="personal.address"></span>
                                </div>
                                
                                {{-- Summary Section --}}
                                <div class="mt-6">
                                    <h3 class="text-lg font-heading font-bold border-b-2 border-gray-200 pb-1 mb-2 tracking-widest">{{ __('SUMMARY') }}</h3>
                                    <p class="text-gray-700 text-sm whitespace-pre-wrap" x-text="personal.summary"></p>
                                </div>
                                
                                {{-- Work Experience Section --}}
                                <div class="mt-6">
                                    <h3 class="text-lg font-heading font-bold border-b-2 border-gray-200 pb-1 mb-2 tracking-widest">{{ __('WORK EXPERIENCE') }}</h3>
                                    <template x-for="exp in experiences" :key="exp.id">
                                        <div class="mb-4">
                                            <div class="flex justify-between items-baseline">
                                                <h4 class="font-bold text-primary" x-text="exp.job_title"></h4>
                                                <p class="text-sm text-gray-600" x-text="exp.start_date + ' - ' + (exp.end_date || 'Present')"></p>
                                            </div>
                                            <p class="text-sm italic" x-text="exp.company"></p>
                                            {{-- Displaying the description --}}
                                            <p class="text-sm text-gray-700 mt-1 whitespace-pre-wrap" x-text="exp.description"></p>
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
</x-app-layout>