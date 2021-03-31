<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\User::class, 50)->create()->each(function($user){
          $user->questions()
          ->saveMany(
            factory(App\Question::class, rand(1,5))->make()
          )->each(function($question){
            $question->answers()->saveMany(
              factory(App\Answer::class, rand(1,5))->make()
            );
          });
        });
    }
}
