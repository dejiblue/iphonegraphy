<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Helpers\UserHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockLessonWatchedAchievement
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
     * @param  LessonWatched  $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {
        $user = $event->user;

        $userHelper = new UserHelper();
        $userHelper->unlockUserLessonWatchedAchievement($user);
    }
}
