<?php

namespace App\Http\Controllers;

use App\Enums\NotificationType;
use App\Http\Requests\StoreNotificationPostRequest;
use App\Models\NotificationPost;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class NotificationPostController extends Controller
{
    /**
     * Show the notifications page with the form to post a new one.
     */
    public function index(): View
    {
        return view('notifications.index', [
            'types' => NotificationType::cases(),
            'users' => User::query()->orderBy('name')->get(['id', 'name', 'email']),
        ]);
    }

    /**
     * Store a new notification and assign it to its recipients.
     */
    public function store(StoreNotificationPostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $recipientIds = $data['recipient'] === 'all'
            ? User::query()->pluck('id')
            : [$data['recipient']];

        DB::transaction(function () use ($data, $recipientIds) {
            $post = NotificationPost::create([
                'type' => $data['type'],
                'text' => $data['text'],
                'expires_at' => $data['expires_at'],
            ]);

            $post->recipients()->attach($recipientIds);
        });

        return redirect()
            ->route('notifications.index')
            ->with('status', 'Notification sent to ' . count($recipientIds) . ' user(s).');
    }
}
