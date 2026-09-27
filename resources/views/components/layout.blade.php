@props(['title' => config('app.name')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }} · {{ config('app.name') }}</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-50 font-sans text-gray-900 antialiased">
        <header class="border-b border-gray-200 bg-white">
            <nav class="mx-auto flex max-w-5xl items-center gap-6 px-4 py-4">
                <a href="{{ route('users.index') }}" class="font-semibold">{{ config('app.name') }}</a>
                <a href="{{ route('users.index') }}"
                   class="text-sm {{ request()->routeIs('users.*') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                    Users
                </a>
                <a href="{{ route('notifications.index') }}"
                   class="text-sm {{ request()->routeIs('notifications.*') ? 'text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                    All notifications
                </a>
            </nav>
        </header>

        <main class="mx-auto max-w-5xl px-4 py-8">
            {{ $slot }}
        </main>
    </body>
</html>
