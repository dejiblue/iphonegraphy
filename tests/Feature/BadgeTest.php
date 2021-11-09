<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Badge;
use App\Models\Achievement;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BadgeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function badge_table_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('badges', [
                'id','name','user_id'
            ]), 1);
    }

    /**
     * @test
     */
    public function a_user_can_earn_intermediate_badge_on_four_achievements()
    {
        $user = User::factory()->create();
        $comment = Achievement::factory(3)->create(['user_id' => $user->id]);

        $response = $this->post('/user/comment', [
            'user_id' => $user->id,
            'body' => 'Some lorem ipsum text.'
        ]);

        $response->assertOk();
        $response->assertStatus(200);
        $this->assertEquals(1, $user->badge->count());
        $this->assertEquals('Intermediate', $user->badge->name);
        $this->assertInstanceOf(BADGE::class, $user->badge);
    }
}
