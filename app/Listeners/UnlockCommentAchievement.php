<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Helpers\UserHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockCommentAchievement
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
     * @param  CommentWritten  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        $comment = $event->comment;
        $user = $event->user;

        $userHelper = new UserHelper();
        $userHelper->unlockUserCommentAchievement($user);
    }
}
