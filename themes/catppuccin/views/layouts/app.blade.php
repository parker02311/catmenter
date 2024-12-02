<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- Software build by https://paymenter.org -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        if ("{{ config('settings::theme:snow') }}" == 1) {
            document.addEventListener("DOMContentLoaded", function() {
                window.snow();
            });
        }
        window.addEventListener('keydown', function(e) {
            var ctrlDown = true;
            var ctrlKey = 17,
                enterKey = 13;
            $(document).keydown(function(e) {
                if (e.keyCode == ctrlKey) ctrlDown = true;
                if (e.keyCode == enterKey && ctrlDown) {
                    if ($('#submit').length) {
                        $('#submit').click();
                    }
                }
            }).keyup(function(e) {
                if (e.keyCode == ctrlKey) ctrlDown = false;
            });
        });
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            // document.documentElement.classList.add('dark');
            document.body.classList.remove('ctp-latte');
        } else {
            // document.documentElement.classList.remove('dark');
            document.body.classList.add('ctp-latte');
        }
    </script>
    <style>
        .snow {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
            pointer-events: none;
        }
    </style>
    @empty($title)
        <title>{{ config('app.name', 'Paymenter') }}</title>
    @else
        <title>{{ config('app.name', 'Paymenter') . ' - ' . ucfirst($title) }}</title>
    @endempty

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;700&display=swap">

    @vite(['themes/' . config('settings::theme-active') . '/js/app.js', 'themes/' . config('settings::theme-active') . '/css/app.css'], config('settings::theme-active'))

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    @if (config('settings::app_logo'))
        <link rel="icon" href="{{ asset(config('settings::app_logo')) }}" type="image/png">
    @else
        <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
    @endif
    <meta content="{{ ucfirst($title) ?? config('settings::seo_title') }}" property="og:title">
    <meta content="{{ $description ?? config('settings::seo_description') }}" property="og:description">
    <meta content="{{ $description ?? config('settings::seo_description') }}" name="description">
    <meta content='{{ $image ?? config('settings::seo_image') }}' property='og:image'>
    <link type="application/json+oembed"
        href="{{ url('/') }}/manifest.json?title={{ config('app.name', 'Paymenter') }}&author_url={{ url('/') }}&author_name={{ config('app.name', 'Paymenter') }}" />
    <meta name="twitter:card" content="@if (config('settings::seo_twitter_card')) summary_large_image @endif">
    <meta name="theme-color" content="#5270FD">
</head>

<body class="font-sans bg-ctp-base text-ctp-text dark">

    @if (config('settings::theme:snow') == 1)
        <canvas class="snow" id="snow" width="1920" height="1080"></canvas>
    @endif
    <div id="app" class="min-h-screen">
        <x-paymenter-update />
        @if (!$clients || config('settings::sidebar') == 0)
            @include('layouts.navigation')
        @endif
        <div class="@if (config('settings::sidebar') == 1) flex md:flex-nowrap flex-wrap @endif">
            @if ($clients)
                @include('layouts.subnavigation')
            @endif
            <div class="w-full flex flex-col @if ($clients) min-h-[calc(100vh-105px)] @else min-h-[calc(100vh-64px)] @endif">
                
                <main class="grow">
                    {{ $slot }}
                </main>

                <x-footer />
            </div>
        </div>
    </div>
</body>

</html>
