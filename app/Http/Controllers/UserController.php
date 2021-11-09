<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use Illuminate\Http\JsonResponse;
use App\Events\AchievementUnlocked;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * enroll a user in a lesson
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function enroll(Request $request): JsonResponse
    {
        $success = false;
        $userId = $request->input('user_id');
        $lessonId = $request->input('lesson_id');
        $user = User::find($userId);
        if ($user && $lessonId) {
            if ($user->lessons()->syncWithoutDetaching($lessonId)) {
                $success = true;
            }
        }
        return response()->json(['success' => $success]);
    }

    /**
     * User creates a comment
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function comment(Request $request): JsonResponse
    {
        $success = false;
        $userId = $request->input('user_id');
        $user = User::find($userId);
        if ($user) {
            $comment = new Comment;
            $comment->user_id = $userId;
            $comment->body = $request->input('body');
            if ($comment->save()) {
                event(new CommentWritten($comment, $user));
                $success = true;
                return response()->json([
                    'success' => $success,
                    'comment' => $comment
                ]);
            }
        }
        return response()->json(['success' => $success]);
    }

    /**
     * User completes a lesson
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function lessonWatched(Request $request): JsonResponse
    {
        $success = false;
        $userId = $request->input('user_id');
        $lessonId = $request->input('lesson_id');
        $user = User::find($userId);
        $lesson = Lesson::find($lessonId);
        if ($user && $lesson) {
            if ($user->lessons()->updateExistingPivot($lesson->id, ['watched' => true])) {
                event(new LessonWatched($lesson, $user));
                $success = true;
                return response()->json(['success' => $success]);
            }
        }
        return response()->json(['success' => $success]);
    }
}
