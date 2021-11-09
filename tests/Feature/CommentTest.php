<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /**
     * @test
     */
    public function comments_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('comments', [
                'id','user_id', 'body'
            ]), 1);
    }

    /**
     * @test
     */
    public function a_user_can_create_a_comment()
    {
        $user = User::factory()->create();

        $response = $this->post('/user/comment', [
            'user_id' => $user->id,
            'body' => 'Some lorem ipsum text.'
        ]);

        $response->assertOk();
        $this->assertCount(1, $user->comments);
        $this->withoutExceptionHandling();
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function a_user_has_many_comments()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->comments->contains($comment));
        $this->assertEquals(1, $user->comments->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->comments);
    }

    /**
     * @test
     */
    public function a_comment_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $this->assertEquals(1, $comment->user->count());
        $this->assertInstanceOf(User::class, $comment->user);
    }

    /**
     * @test
     */
    public function unlock_achievement_with_first_comment()
    {
        $user = User::factory()->create();

        $response = $this->post('/user/comment', [
            'user_id' => $user->id,
            'body' => 'Some lorem ipsum text.'
        ]);

        $response->assertOk();
        $response->assertStatus(200);
        $this->assertEquals(1, $user->achievements->count());
    }
}
