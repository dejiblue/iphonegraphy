<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Helpers\UserHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockAchievement
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AchievementUnlocked  $event
     * @return void
     */
    public function handle(AchievementUnlocked $event)
    {
        $achievementName = $event->achievement_name;
        $user = $event->user;

        $userHelper = new UserHelper();
        $userHelper->saveUserAchievement($user, $achievementName);
    }
}
