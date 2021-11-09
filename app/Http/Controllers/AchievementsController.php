<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AchievementsController
 * @package App\Http\Controllers
 */
class AchievementsController extends Controller
{
    private const COMMENT_ACHIEVEMENTS = [
        'First Comment Written',
        '3 Comments Written',
        '5 Comments Written',
        '10 Comments Written',
        '20 Comments Written'
    ];

    private const LESSON_ACHIEVEMENTS = [
        'First Lesson Watched',
        '5 Lessons Watched',
        '10 Lessons Watched',
        '25 Lessons Watched',
        '50 Lessons Watched'
    ];
    
    /**
     * @param $userId
     * @return JsonResponse
     */
    public function index($userId): JsonResponse
    {
        $allowed_badges = [
            'Beginner',
            'Intermediate',
            'Advanced',
            'Master'
        ];

        $user = User::findorFail($userId);
        $unlocked_achievements = [];
        $unlocked_lesson_achievements = [];
        $unlocked_comment_achievements = [];

        foreach ($user->achievements()->get() as $achievement) {
            $unlocked_achievements[] = $achievement->name;

            if (strpos($achievement->name, 'Comment')) {
                $unlocked_comment_achievements[] = $achievement->name;
            }

            if (strpos($achievement->name, 'Lesson')) {
                $unlocked_lesson_achievements[] = $achievement->name;
            }
        }

        $available_lesson_achievement = array_diff(
            self::LESSON_ACHIEVEMENTS,
            $unlocked_lesson_achievements
        );

        $available_comment_achievement = array_diff(
            self::COMMENT_ACHIEVEMENTS,
            $unlocked_comment_achievements
        );

        $next_available_achievements = [
            'lesson_achievements' => current($available_lesson_achievement),
            'comment_achievements' => current($available_comment_achievement)
        ];

        $next_badge = null;
        $badge = Badge::where('user_id', $user->id)->first();
        if ($badge) {
            $index = array_search($badge->name, $allowed_badges);
            if ($index !== false && $index < count($allowed_badges) - 1) {
                $next_badge = $allowed_badges[$index + 1];
            }
        }

        $achievement_count = $user->achievements()->count();
        $remains_till_next_badge = null;
        if ($achievement_count < 4) {
            $remains_till_next_badge = 4 - $achievement_count;
        }
        if ($achievement_count < 8 && $achievement_count >= 4) {
            $remains_till_next_badge = 8 - $achievement_count;
        }
        if ($achievement_count < 10 && $achievement_count >= 8) {
            $remains_till_next_badge = 10 - $achievement_count;
        }

        return response()->json([
            'unlocked_achievements' => $unlocked_achievements,
            'next_available_achievements' => $next_available_achievements,
            'current_badge' => $badge->name ?? current($allowed_badges),
            'next_badge' => $next_badge ?? next($allowed_badges),
            'remaing_to_unlock_next_badge' => $remains_till_next_badge
        ]);
    }
}
