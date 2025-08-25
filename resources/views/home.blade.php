@section('title', 'AfterCV | Your First Step Towards a Promising Career')
@section('description', 'Build a professional CV in minutes and discover thousands of job and academic opportunities that match your ambitions.')

<x-guest-layout>
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
    </style>

    <div class="bg-white text-gray-800">
        <!-- Header -->
        <header class="absolute top-0 left-0 w-full z-30 px-4 sm:px-6 lg:px-8 transition-all duration-300">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between h-16 md:h-20">
                    <!-- Logo -->
                    <div class="shrink-0">
                        <a href="{{ route('welcome', app()->getLocale()) }}">
                            <x-application-logo class="h-10 w-auto" />
                        </a>
                    </div>
                    <!-- Navigation -->
                    <nav class="flex items-center">
                        <ul class="flex items-center">
                            <li>
                                <a href="{{ route('login', app()->getLocale()) }}" class="font-medium text-primary hover:text-opacity-80 px-4 py-2 flex items-center transition duration-150 ease-in-out">
                                    {{ __('Log in') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register', app()->getLocale()) }}" class="inline-flex items-center text-white bg-primary hover:bg-opacity-90 ml-3 rounded-md px-4 py-2 shadow-lg transition">
                                    <span>{{ __('Sign up') }}</span>
                                    <svg class="w-3 h-3 fill-current text-white shrink-0 ml-2" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.707 5.293L7 .586 5.586 2l3 3H0v2h8.586l-3 3L7 11.414l4.707-4.707a1 1 0 000-1.414z" fill-rule="nonzero" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <main class="grow">
            <!-- Hero Section -->
            <section class="relative pt-32 pb-12 md:pt-40 md:pb-20">
                <div class="max-w-6xl mx-auto px-4 sm:px-6">
                    <div class="text-center pb-12 md:pb-16">
                        <h1 class="text-5xl md:text-6xl font-extrabold font-heading leading-tighter tracking-tighter mb-4 fade-in" data-aos="fade-up">
                            From <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">CV</span> to Career
                        </h1>
                        <div class="max-w-3xl mx-auto">
                            <p class="text-xl text-gray-600 mb-8 fade-in-up" style="animation-delay: 200ms;" data-aos="fade-up" data-aos-delay="200">
                                {{ __('Build a professional CV in minutes and discover thousands of job and academic opportunities that match your ambitions.') }}
                            </p>
                            <div class="fade-in-up" style="animation-delay: 400ms;">
                                <a class="inline-block text-white bg-primary hover:bg-opacity-90 font-bold rounded-lg py-3 px-8 shadow-lg transition" href="{{ route('register', app()->getLocale()) }}">
                                    {{ __('Get Started For Free') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="relative bg-gray-50 py-16 sm:py-24">
                <div class="max-w-6xl mx-auto px-4 sm:px-6">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-heading font-extrabold text-primary">{{ __('Everything you need to succeed') }}</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="text-center p-6 bg-white rounded-lg shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary/10 mx-auto mb-4">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">{{ __('Intelligent CV Builder') }}</h3>
                            <p class="text-gray-600">{{ __('Create a professional, ATS-friendly CV with our step-by-step guided builder.') }}</p>
                        </div>
                        <!-- Feature 2 -->
                        <div class="text-center p-6 bg-white rounded-lg shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary/10 mx-auto mb-4">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">{{ __('Targeted Opportunities') }}</h3>
                            <p class="text-gray-600">{{ __('Access a curated list of jobs, scholarships, and internships that match your profile.') }}</p>
                        </div>
                        <!-- Feature 3 -->
                        <div class="text-center p-6 bg-white rounded-lg shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary/10 mx-auto mb-4">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.148-6.014a1.76 1.76 0 011.17-2.121l6.014-2.148a1.76 1.76 0 012.121 1.17z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">{{ __('Direct Application') }}</h3>
                            <p class="text-gray-600">{{ __('Apply to opportunities directly through the platform with just a few clicks.') }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Final CTA Section -->
            <section class="py-16 sm:py-24">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl md:text-4xl font-heading font-extrabold text-primary mb-4">{{ __('Ready to take the next step?') }}</h2>
                    <p class="text-lg text-gray-600 mb-8">{{ __('Join thousands of professionals and start your journey with AfterCV today.') }}</p>
                    <a class="inline-block text-white bg-primary hover:bg-opacity-90 font-bold rounded-lg py-3 px-8 shadow-lg transition" href="{{ route('register', app()->getLocale()) }}">
                        {{ __('Create Your CV Now') }}
                    </a>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-100 border-t py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} AfterCV. All rights reserved.</p>
                <div class="mt-4">
                    <a href="{{ route('privacy.policy', app()->getLocale()) }}" class="hover:underline mx-2">{{ __('Privacy Policy') }}</a>
                    <span>&middot;</span>
                    <a href="{{ route('terms.service', app()->getLocale()) }}" class="hover:underline mx-2">{{ __('Terms of Service') }}</a>
                </div>
            </div>
        </footer>
    </div>
</x-guest-layout>
