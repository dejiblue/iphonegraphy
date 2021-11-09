<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AchievementUnlocked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $achievement_name;

    /**
     * Create a new event instance.
     *
     * @param string $achievement_name
     * @param User $user
     */
    public function __construct(string $achievement_name, User $user)
    {
        $this->achievement_name = $achievement_name;
        $this->user = $user;
    }
}
