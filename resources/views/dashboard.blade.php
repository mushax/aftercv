<x-app-layout>
    {{-- Header Section --}}
    <x-slot name="header">
        <h2 class="font-heading text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Main Content Area --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-heading text-2xl text-primary font-bold">
                            {{ __("Welcome back, :name!", ['name' => Auth::user()->name]) }}
                        </h3>
                        
                        <div class="mt-4 border-t pt-4">
                            <p class="font-bold">{{ __('Profile Completion') }}: 80%</p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-secondary h-2.5 rounded-full" style="width: 80%"></div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">
                                {{ __("Your profile is strong! Add a projects section for better opportunities.") }}
                            </p>
                        </div>

                        {{-- Quick Access Buttons --}}
                        <div class="mt-6 flex space-x-4 rtl:space-x-reverse">
                            <a href="#" class="bg-primary text-white font-bold py-2 px-4 rounded hover:bg-opacity-90 transition">
                                {{ __('Edit CV') }}
                            </a>
                            <a href="#" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded hover:bg-gray-300 transition">
                                {{ __('View Public Link') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-heading text-2xl font-bold mb-4">{{ __('Recommended Opportunities For You') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Placeholder Card 1 --}}
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h4 class="font-bold text-lg text-primary">Senior Frontend Developer</h4>
                            <p class="text-gray-600">Tech Solutions Inc.</p>
                            <p class="text-sm text-gray-500 mt-2">Riyadh, Saudi Arabia</p>
                            <span class="inline-block bg-secondary bg-opacity-20 text-secondary text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full mt-2">{{ __('Full-time') }}</span>
                        </div>
                        {{-- Placeholder Card 2 --}}
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h4 class="font-bold text-lg text-primary">Marketing Manager</h4>
                            <p class="text-gray-600">Creative Minds Agency</p>
                            <p class="text-sm text-gray-500 mt-2">Dubai, UAE</p>
                             <span class="inline-block bg-secondary bg-opacity-20 text-secondary text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full mt-2">{{ __('Full-time') }}</span>
                        </div>
                        {{-- Placeholder Card 3 --}}
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h4 class="font-bold text-lg text-primary">Data Science Scholarship</h4>
                            <p class="text-gray-600">Future Coders Academy</p>
                            <p class="text-sm text-gray-500 mt-2">Remote</p>
                             <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full mt-2">{{ __('Scholarship') }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-heading text-2xl font-bold mb-4">{{ __('Your Recent Applications') }}</h3>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <p class="text-gray-500">{{ __("You haven't applied to any opportunities yet.") }}</p>
                            {{-- This table will be shown when there is data --}}
                            {{-- 
                            <table class="w-full text-left">
                                <thead>
                                    <tr>
                                        <th class="p-2 font-bold">{{ __('Job Title') }}</th>
                                        <th class="p-2 font-bold">{{ __('Company') }}</th>
                                        <th class="p-2 font-bold">{{ __('Date Applied') }}</th>
                                        <th class="p-2 font-bold">{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t">
                                        <td class="p-2">UI/UX Designer</td>
                                        <td class="p-2">Innovate Tech</td>
                                        <td class="p-2">Aug 15, 2025</td>
                                        <td class="p-2"><span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ __('Under Review') }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            --}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>