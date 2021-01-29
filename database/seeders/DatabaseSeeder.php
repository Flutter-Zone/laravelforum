<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory(3)->create()->each(function (User $user) {
            $user->questions()
            ->saveMany(Question::factory(rand(1, 30))->make())
            ->each(function ($question) {
                $question->answers()->saveMany(Answer::factory(rand(1, 5))->make());
            });
        });
    }
}
