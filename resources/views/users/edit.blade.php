<x-layout title="Edit {{ $user->name }}">
    <h1 class="mb-6 text-2xl font-semibold">Notification settings of {{ $user->name }}</h1>

    <form method="POST" action="{{ route('users.update', $user) }}"
          class="max-w-lg space-y-5 rounded-lg border border-gray-200 bg-white p-6">
        @csrf
        @method('PUT')

        <div>
            <label class="flex items-center gap-3 text-sm font-medium">
                {{-- An unchecked checkbox is not sent, so the hidden field supplies the "off" value. --}}
                <input type="hidden" name="notifications_enabled" value="0">
                <input type="checkbox" name="notifications_enabled" value="1"
                       class="size-4 rounded border-gray-300"
                       @checked(old('notifications_enabled', $user->notifications_enabled))>
                On-screen notifications
            </label>
            @error('notifications_enabled')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium">Email</label>
            <input id="email" name="email" type="email" required maxlength="255"
                   value="{{ old('email', $user->email) }}"
                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone_number" class="mb-1 block text-sm font-medium">Phone number</label>
            <input id="phone_number" name="phone_number" type="tel" maxlength="20"
                   value="{{ old('phone_number', $user->phone_number) }}"
                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
            @error('phone_number')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('users.index') }}"
               class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit"
                    class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
                Save
            </button>
        </div>
    </form>
</x-layout>
