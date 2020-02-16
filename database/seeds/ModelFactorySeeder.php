<?php

use Illuminate\Database\Seeder;

class ModelFactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create();
        factory(App\Thread::class, 10)->create();
        factory(App\Channel::class, 10)->create();
        factory(App\Reply::class,10)->create();
        factory(\Illuminate\Notifications\DatabaseNotification::class, 10)->create();
    }
}
