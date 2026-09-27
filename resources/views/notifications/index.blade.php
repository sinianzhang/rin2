<x-layout title="All notifications">
    <h1 class="mb-6 text-2xl font-semibold">All notifications</h1>

    @if (session('status'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <section class="mb-10 rounded-lg border border-gray-200 bg-white p-6">
        <h2 class="mb-4 text-lg font-semibold">New notification</h2>

        <form method="POST" action="{{ route('notifications.store') }}" class="grid gap-4 sm:grid-cols-2">
            @csrf

            <div>
                <label for="type" class="mb-1 block text-sm font-medium">Type</label>
                <select id="type" name="type" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                    @foreach ($types as $type)
                        <option value="{{ $type->value }}" @selected(old('type') === $type->value)>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="recipient" class="mb-1 block text-sm font-medium">Destination</label>
                <select id="recipient" name="recipient" required
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                    <option value="all" @selected(old('recipient', 'all') === 'all')>All users</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(old('recipient') == $user->id)>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('recipient')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="text" class="mb-1 block text-sm font-medium">Text</label>
                <textarea id="text" name="text" rows="4" maxlength="5000" required
                          class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">{{ old('text') }}</textarea>
                @error('text')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="expires_at" class="mb-1 block text-sm font-medium">Expires at</label>
                <input id="expires_at" name="expires_at" type="datetime-local" required value="{{ old('expires_at') }}"
                       class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                @error('expires_at')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-end sm:justify-end">
                <button type="submit"
                        class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
                    Send notification
                </button>
            </div>
        </form>
    </section>

    <h2 class="mb-4 text-lg font-semibold">Not expired notifications</h2>

    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3 font-medium">Created</th>
                    <th class="px-4 py-3 font-medium">Type</th>
                    <th class="px-4 py-3 font-medium">Text</th>
                    <th class="px-4 py-3 font-medium">Destination</th>
                    <th class="px-4 py-3 font-medium">Read/Total</th>
                    <th class="px-4 py-3 font-medium">Expires</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($posts as $post)
                    <tr class="align-top">
                        <td class="whitespace-nowrap px-4 py-3">{{ $post->created_at->format('d.m.Y H:i') }}</td>
                        <td class="px-4 py-3">{{ $post->type->label() }}</td>
                        <td class="max-w-md break-words px-4 py-3">
                            <button type="button" popovertarget="post-text-{{ $post->id }}"
                                    class="cursor-pointer text-gray-500 underline hover:text-gray-900">
                                details
                            </button>

                            {{-- Native HTML popover: opens above the page, so the table layout stays unchanged. --}}
                            <div id="post-text-{{ $post->id }}" popover
                                    class="m-auto max-h-[80vh] w-full max-w-lg overflow-y-auto rounded-lg border border-gray-200 bg-white p-6 shadow-xl backdrop:bg-gray-900/30">
                                <div class="mb-4 flex items-start justify-between gap-4">
                                    <p class="text-sm text-gray-500">
                                        {{ $post->type->label() }} · {{ $post->created_at->format('d.m.Y H:i') }} · 
                                        @if ($post->recipients_count === 1)
                                            {{ $post->recipients->first()->name }}
                                        @else
                                            {{ $post->recipients_count }} Users
                                        @endif
                                    </p>
                                    <button type="button" popovertarget="post-text-{{ $post->id }}" popovertargetaction="hide"
                                            class="cursor-pointer text-sm text-gray-500 hover:text-gray-900">
                                        Close
                                    </button>
                                </div>
                                <p class="whitespace-pre-line break-words text-sm">{{ $post->text }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if ($post->recipients_count === 1)
                                {{ $post->recipients->first()->name }}
                            @else
                                {{ $post->recipients_count }} Users
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-4 py-3">{{ $post->read_count }} / {{ $post->recipients_count }}</td>
                        <td class="whitespace-nowrap px-4 py-3">{{ $post->expires_at->format('d.m.Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No notification found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
