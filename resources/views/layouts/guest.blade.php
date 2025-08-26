<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- START: SEO Customization --}}
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <meta name="description" content="@yield('description', 'Your default site description here.')">
    {{-- END: SEO Customization --}}


    <link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=cairo:700,900|tajawal:400,500|noto-color-emoji:400&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
            <x-analytics-script />

</head>
    <body class="font-body text-gray-900 antialiased">
        <div class="min-h-screen bg-gray-100">
            {{-- سنضيف هنا لاحقاً هيدر وفوتر للصفحة الرئيسية --}}
            
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>