@php($unreadCount = $notifications->count())

<x-layout title="Home">
    <x-slot:header>
        <nav class="mx-auto flex max-w-5xl items-center gap-6 px-4 py-4">
            <a href="{{ route('home') }}" class="font-semibold">{{ config('app.name') }}</a>

            <div class="ml-auto flex items-center gap-4 text-sm">
                {{-- The bell is shown only with on-screen notifications switched on; it only opens the list when there is something unread. --}}
                @if ($user->notifications_enabled)
                    @if ($unreadCount > 0)
                        <button type="button" popovertarget="notifications"
                                class="relative cursor-pointer text-gray-500 hover:text-gray-900"
                                aria-label="{{ $unreadCount }} unread notifications">
                            <x-bell-icon />
                            <span class="absolute -right-2 -top-2 min-w-5 rounded-full bg-red-600 px-1 text-center text-xs font-semibold leading-5 text-white">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                        </button>
                    @else
                        <span class="relative text-gray-300" aria-label="No unread notifications">
                            <x-bell-icon />
                            <span class="absolute -right-2 -top-2 min-w-5 rounded-full bg-gray-200 px-1 text-center text-xs font-semibold leading-5 text-gray-500">
                                0
                            </span>
                        </span>
                    @endif
                @endif

                <span class="text-gray-500">Logged in as <span class="font-medium text-gray-900">{{ $user->name }}</span></span>

                <form method="POST" action="{{ route('impersonate.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-500 hover:text-gray-900">Log out</button>
                </form>
            </div>
        </nav>
    </x-slot:header>

    @if ($unreadCount > 0)
        {{-- Native HTML popover, pinned under the top bar at the right edge of the content column. --}}
        <div id="notifications" popover
             class="inset-auto top-16 right-[max(1rem,calc((100vw_-_64rem)/2_+_1rem))] m-0 max-h-[70vh] w-80 overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-xl">
            <p class="border-b border-gray-100 px-4 py-3 text-sm font-semibold">Notifications</p>

            <ul class="divide-y divide-gray-100">
                @foreach ($notifications as $notification)
                    <li class="flex items-start gap-3 px-4 py-3">
                        <div class="min-w-0 flex-1">
                            <p class="mb-1 text-xs text-gray-500">
                                {{ $notification->type->label() }} · {{ $notification->created_at->format('d.m.Y H:i') }}
                            </p>
                            <p class="whitespace-pre-line break-words text-sm">{{ $notification->text }}</p>
                        </div>

                        <form method="POST" action="{{ route('home.notifications.read', $notification) }}">
                            @csrf
                            <button type="submit" class="cursor-pointer text-lg leading-none text-gray-400 hover:text-gray-900"
                                    aria-label="Mark as read" title="Mark as read">
                                &times;
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

        @if (session('notifications_open'))
            <script>document.getElementById('notifications').showPopover();</script>
        @endif
    @endif

    <h1 class="mb-2 text-2xl font-semibold">Welcome, {{ $user->name }}</h1>
    <p class="text-gray-500">{{ $user->email }}</p>
</x-layout>
