<?php

namespace App\Helpers;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;

class UserHelper
{
    private const BEGINNER_BADGE      = 'Beginner';
    private const INTERMEDIATE_BADGE  = 'Intermediate';
    private const ADVANCED_BADGE      = 'Advanced';
    private const MASTER_BADGE        = 'Master';
    private const FIRST_LESSON        = 'First Lesson Watched';
    private const FIVE_LESSONS        = '5 Lessons Watched';
    private const TEN_LESSONS         = '10 Lessons Watched';
    private const TWENTY_FIVE_LESSONS = '25 Lessons Watched';
    private const FIFTY_LESSONS       = '50 Lessons Watched';
    private const FIRST_COMMENT       = 'First Comment Written';
    private const THREE_COMMENTS      = '3 Comments Written';
    private const FIVE_COMMENTS       = '5 Comments Written';
    private const TEN_COMMENTS        = '10 Comments Written';
    private const TWENTY_COMMENTS     = '20 Comments Written';

    /**
     * @param User $user
     * @param string $achievementName
     * @return bool
     */
    public function saveUserAchievement(User $user, string $achievementName): bool
    {
        $achievement = new Achievement;
        $achievement->user_id = $user->id;
        $achievement->name = $achievementName;
        if ($achievement->save()) {
            $this->unlockUserBadge($user);
            return true;
        }
        return false;
    }

    /**
     * @param User $user
     * @param string $badgeName
     */
    public function saveUserBadge(User $user, string $badgeName)
    {
        $badge = Badge::updateOrCreate(
            ['user_id' => $user->id],
            ['name' => $badgeName]
        );
        return $badge;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function unlockUserBadge(User $user): bool
    {
        $result = true;
        $achievementCount = $user->achievements()->count();
        switch ($achievementCount) {
            case 4:
                event(new BadgeUnlocked(self::INTERMEDIATE_BADGE, $user));
                break;
            case 8:
                event(new BadgeUnlocked(self::ADVANCED_BADGE, $user));
                break;
            case 10:
                event(new BadgeUnlocked( self::MASTER_BADGE, $user));
                break;
            default:
                $result = false;
        }
        return $result;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function unlockUserCommentAchievement(User $user): bool
    {
        $result = true;
        $commentCount = $user->comments()->count();
        switch ($commentCount) {
            case 1:
                event(new AchievementUnlocked(self::FIRST_COMMENT, $user));
                break;
            case 3:
                event(new AchievementUnlocked(self::THREE_COMMENTS, $user));
                break;
            case 5:
                event(new AchievementUnlocked(self::FIVE_COMMENTS, $user));
                break;
            case 10:
                event(new AchievementUnlocked(self::TEN_COMMENTS, $user));
                break;
            case 20:
                event(new AchievementUnlocked(self::TWENTY_COMMENTS, $user));
                break;
            default:
                $result = false;
        }
        return $result;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function unlockUserLessonWatchedAchievement(User $user): bool
    {
        $result = true;
        $lessonWatched = $user->lessons()->newPivotStatement()
            ->where('watched', '=', true)
            ->count();

        switch ($lessonWatched) {
            case 1:
                event(new AchievementUnlocked(self::FIRST_LESSON, $user));
                break;
            case 5:
                event(new AchievementUnlocked(self::FIVE_LESSONS, $user));
                break;
            case 10:
                event(new AchievementUnlocked(self::TEN_LESSONS, $user));
                break;
            case 25:
                event(new AchievementUnlocked(self::TWENTY_FIVE_LESSONS, $user));
                break;
            case 50:
                event(new AchievementUnlocked(self::FIFTY_LESSONS, $user));
                break;
            default:
                $result = false;
        }
        return $result;
    }
}
