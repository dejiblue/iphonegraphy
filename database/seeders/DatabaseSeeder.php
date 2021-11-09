<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $lessons = Lesson::factory()
            ->count(20)
            ->create();

        // Only create the first user with email user1@test.com
        if (!User::whereEmail('user1@test.com')->first()) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'user1@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('User1@2021'), // password
                'remember_token' => Str::random(10),
            ]);

            $user->lessons()->sync(array(1, 3, 5, 8, 15, 19, 20));
        }
    }
}
