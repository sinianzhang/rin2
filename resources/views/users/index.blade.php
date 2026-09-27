<x-layout title="Users">
    <h1 class="mb-6 text-2xl font-semibold">Users</h1>

    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3 font-medium">Name</th>
                    <th class="px-4 py-3 font-medium">Email</th>
                    <th class="px-4 py-3 font-medium">Phone</th>
                    <th class="px-4 py-3 font-medium">Unread notification(s)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $user)
                    <tr>
                        <td class="px-4 py-3">
                            {{-- POST, not a link: impersonating changes the session. --}}
                            <form method="POST" action="{{ route('impersonate.store', $user) }}">
                                @csrf
                                <button type="submit" class="font-medium text-blue-600 hover:underline">{{ $user->name }}</button>
                            </form>
                        </td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->phone_number ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if ($user->unread_notifications_count > 0)
                                <span class="text-black-400">{{ $user->unread_notifications_count }}</span>
                            @else
                                <span class="text-black-400">0</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
