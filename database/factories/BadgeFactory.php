<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Database\Eloquent\Factories\Factory;

class BadgeFactory extends Factory
{
    private const BADGES = [
        'Beginner',
        'Intermediate',
        'Advanced',
        'Master'
    ];

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Badge::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $badge = collect(self::BADGES)->random();
        return [
            'name' => $badge,
            'user_id' => User::factory(),
        ];
    }
}
