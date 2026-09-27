<x-layout title="Home">
    <x-slot:header>
        <nav class="mx-auto flex max-w-5xl items-center gap-6 px-4 py-4">
            <a href="{{ route('home') }}" class="font-semibold">{{ config('app.name') }}</a>

            <div class="ml-auto flex items-center gap-4 text-sm">
                <span class="text-gray-500">Logged in as <span class="font-medium text-gray-900">{{ $user->name }}</span></span>

                <form method="POST" action="{{ route('impersonate.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-500 hover:text-gray-900">Log out</button>
                </form>
            </div>
        </nav>
    </x-slot:header>

    <h1 class="mb-2 text-2xl font-semibold">Welcome, {{ $user->name }}</h1>
    <p class="text-gray-500">{{ $user->email }}</p>
</x-layout>
