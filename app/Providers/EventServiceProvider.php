<?php

namespace App\Providers;

use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Events\BadgeUnlocked;
use App\Events\AchievementUnlocked;
use App\Listeners\UnlockAchievement;
use App\Listeners\UnlockBadge;
use Illuminate\Support\Facades\Event;
use App\Listeners\UnlockCommentAchievement;
use App\Listeners\UnlockLessonWatchedAchievement;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            UnlockCommentAchievement::class,
        ],
        LessonWatched::class => [
            UnlockLessonWatchedAchievement::class,
        ],
        AchievementUnlocked::class => [
            UnlockAchievement::class,
        ],
        BadgeUnlocked::class => [
            UnlockBadge::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
