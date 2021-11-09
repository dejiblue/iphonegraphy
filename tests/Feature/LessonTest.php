<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LessonTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /**
     * @test
     */
    public function lessons_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('lessons', [
                'id','title'
            ]), 1);
    }

    /**
     * @test
     */
    public function a_lesson_can_be_created()
    {
        $lesson = Lesson::factory()->create();

        $this->assertEquals(1, $lesson->count());
        $this->assertInstanceOf(Lesson::class, $lesson);
    }

    /**
     * @test
     */
    public function user_can_enroll_for_a_lesson()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();

        $response = $this->post('/user/enroll/lesson', [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id
        ]);

        $response->assertOk();
        $response->assertStatus(200);
        $this->assertEquals(1, $user->lessons->count());
        $this->assertTrue($user->lessons->contains($lesson));
    }

    /**
     * @test
     */
    public function a_user_lesson_watched_can_be_updated()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $user->lessons()->sync($lesson->id);

        $response = $this->post('/user/lesson/watched', [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id
        ]);

        $lessonWatched = $user->lessons()->newPivotStatement()
            ->where('watched', '=', true)
            ->count();

        $response->assertOk();
        $this->withoutExceptionHandling();
        $response->assertStatus(200);
        $this->assertEquals(1, $lessonWatched);
    }

    /**
     * @test
     */
    public function unlock_achievement_with_first_lesson_watched()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $user->lessons()->sync($lesson->id);

        $response = $this->post('/user/lesson/watched', [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id
        ]);

        $response->assertOk();
        $response->assertStatus(200);
        $this->assertEquals(1, $user->achievements->count());
    }
}
