<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AchievementStatisticsTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /**
     * @test
     */
    public function test_achievement_statistics()
    {
        $user = User::factory()->create();

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertOk();
        $response->assertStatus(200);
    }
}
