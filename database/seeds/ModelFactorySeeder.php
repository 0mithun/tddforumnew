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
        factory(App\Admin::class)->create();
        factory(App\User::class)->create([
            'name' => 'Jason Payne',
            'first_name' => 'Jason',
            'last_name' => 'Payne',
            'email' =>'kakooljay@gmail.com',
            'username'  =>  'jasonpayne',
            'password' =>  bcrypt('secret'),
            'remember_token' => str_random(10),
            'confirmed' => true
        ]);
        factory(App\User::class, 10)->create();

//        factory(App\Channel::class, 10)->create();
        $channels = [
            'Other','Architecture','Art','Books','Business', 'Celebrities','Death','Dumb','Education','Entertainment','Food','Funny','History','Insults','Life','Love','Mistakes','Money','Movies',
            'Music','Politics','Pranks','Religion','Science','Sex','Sports','Travel','Television','War',
        ];

        foreach ($channels as $channel){
            factory(App\Channel::class)->create([
                'name'  =>  $channel,
                'slug'  =>  $channel
            ]);
        }
        factory(App\Tags::class, 10)->create();
        factory(App\Thread::class, 10)->create();
        factory(App\Reply::class,10)->create();
        factory(\Illuminate\Notifications\DatabaseNotification::class, 10)->create();

    }
}
