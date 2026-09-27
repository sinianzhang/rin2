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
</x-layout>
