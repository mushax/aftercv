<x-app-layout>
    {{-- We need to add a little bit of custom CSS for the animations --}}
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 1s ease-out forwards; }
        .fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .progress-ring-circle {
            transition: stroke-dashoffset 0.5s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-heading text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">

                <!-- =============== Section 1: Welcome & Stats =============== -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
                    <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                        <!-- Welcome Message & CTA -->
                        <div class="md:col-span-2">
                            <h3 class="font-heading text-3xl text-primary font-bold fade-in">
                                {{ __("Welcome back, :name!", ['name' => Auth::user()->name]) }}
                            </h3>
                            <p class="mt-2 text-lg text-gray-600 fade-in-up" style="animation-delay: 100ms;">
                                You're one step closer to your next opportunity. Let's make your CV shine.
                            </p>
                        </div>
                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div class="fade-in-up" style="animation-delay: 300ms;">
                                <div class="relative w-24 h-24 mx-auto">
                                    <svg class="w-full h-full" viewBox="0 0 36 36">
                                        <path class="text-gray-200" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <path class="text-secondary progress-ring-circle" stroke-width="3" stroke-dasharray="80, 100" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    </svg>
                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-xl font-bold text-primary">80%</div>
                                </div>
                                <p class="mt-2 font-semibold text-gray-700">Profile Completion</p>
                            </div>
                            <div class="fade-in-up" style="animation-delay: 400ms;">
                                <div class="relative w-24 h-24 mx-auto">
                                     <svg class="w-full h-full" viewBox="0 0 36 36">
                                        <path class="text-gray-200" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <path class="text-primary progress-ring-circle" stroke-width="3" stroke-dasharray="30, 100" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    </svg>
                                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-xl font-bold text-primary">3</div>
                                </div>
                                <p class="mt-2 font-semibold text-gray-700">Recommended Jobs</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- =============== Section 2: Recommended Opportunities & Quick Actions =============== -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <h3 class="font-heading text-2xl font-bold mb-4 text-gray-800">{{ __('Recommended Opportunities For You') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Card 1 -->
                            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                                <h4 class="font-bold text-lg text-primary">Senior Frontend Developer</h4>
                                <p class="text-gray-600">Tech Solutions Inc.</p>
                                <p class="text-sm text-gray-500 mt-2">Riyadh, Saudi Arabia</p>
                                <span class="inline-block bg-secondary/20 text-secondary text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full mt-4">{{ __('Full-time') }}</span>
                            </div>
                            <!-- Card 2 -->
                            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                                <h4 class="font-bold text-lg text-primary">Marketing Manager</h4>
                                <p class="text-gray-600">Creative Minds Agency</p>
                                <p class="text-sm text-gray-500 mt-2">Dubai, UAE</p>
                                 <span class="inline-block bg-secondary/20 text-secondary text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full mt-4">{{ __('Full-time') }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-heading text-2xl font-bold mb-4 text-gray-800">{{ __('Quick Actions') }}</h3>
                        <div class="space-y-4">
                            <a href="{{ route('cv.create', app()->getLocale()) }}" class="flex items-center p-4 bg-white rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-6 h-6 text-primary mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span class="font-semibold text-gray-700">Go to CV Builder</span>
                            </a>
                            <a href="{{ route('cv.download', app()->getLocale()) }}" class="flex items-center p-4 bg-white rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-6 h-6 text-primary mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                <span class="font-semibold text-gray-700">Download as PDF</span>
                            </a>
                             <a href="#" class="flex items-center p-4 bg-white rounded-lg shadow-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-6 h-6 text-primary mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                <span class="font-semibold text-gray-700">View Public Link</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
