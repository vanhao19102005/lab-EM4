@props(['pageTitle' => 'Bean & Bloom'])
@php
    $theme = session('theme', 'auto');
    $locale = app()->currentLocale();
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" class="{{ $theme }}" data-theme="{{ $theme === 'theme-dark' ? 'dark' : 'light' }}">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#219653"><link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <title>{{ $pageTitle }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles @stack('styles')
</head>
<body class="min-h-screen bg-[var(--color-background)] text-[var(--color-on-background)]">
    @php($themeForJs = $theme)
    <script>window.theme = @js($themeForJs);</script>
    {{ $slot }}
    @livewireScripts @stack('scripts')
</body>
</html>
