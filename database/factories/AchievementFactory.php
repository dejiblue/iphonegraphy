<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AchievementFactory
 * @package Database\Factories
 */
class AchievementFactory extends Factory
{
    private const ACHIEVEMENTS = [
        'First Comment Written',
        '3 Comments Written',
        '5 Comments Written',
        '10 Comments Written',
        '20 Comments Written',
        'First Lesson Watched',
        '5 Lessons Watched',
        '10 Lessons Watched',
        '25 Lessons Watched',
        '50 Lessons Watched'
    ];

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Achievement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $achievements = collect(self::ACHIEVEMENTS)->random();
        return [
            'name' => $achievements,
            'user_id' => 'overwritten',
        ];
    }
}
