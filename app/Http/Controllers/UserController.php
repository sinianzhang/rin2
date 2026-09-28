<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Propaganistas\LaravelPhone\PhoneNumber;

class UserController extends Controller
{
    /**
     * List all users, sorted alphabetically by name, with their unread, not expired notification count.
     */
    public function index(): View
    {
        // select() must come before withCount(); columns passed to get() would be ignored.
        $users = User::query()
            ->select(['id', 'name', 'email', 'phone_number', 'notifications_enabled'])
            ->withCount([
                'notificationPosts as notifications_count' => function (Builder $query) {
                    $query->notExpired();
                },
                'notificationPosts as unread_notifications_count' => function (Builder $query) {
                    $query->notExpired()->whereNull('notification_recipients.read_at');
                },
            ])
            ->orderBy('name')
            ->get();

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form to edit a user's notification settings.
     */
    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Save a user's notification settings and go back to the user list.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        // Store one canonical format (E.164, e.g. +4915123456789), whatever spacing was typed.
        if ($data['phone_number'] !== null) {
            $data['phone_number'] = (new PhoneNumber($data['phone_number']))->formatE164();
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('status', "Settings of {$user->name} saved.");
    }
}
