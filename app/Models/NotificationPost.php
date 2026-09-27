<?php

namespace App\Models;

use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['type', 'text', 'expires_at'])]
class NotificationPost extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => NotificationType::class,
            'expires_at' => 'datetime',
        ];
    }

    /**
     * The users this notification was sent to; read_at is NULL while unread.
     */
    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notification_recipients')
            ->withPivot('read_at');
    }
}
