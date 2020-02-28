<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/





/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    $first_name = $faker->word;
    $last_name = $faker->word;
    return [
        'name' => $first_name." ".$last_name,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $faker->unique()->safeEmail,
        'username'  =>  $faker->unique()->word,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmed' => true
    ];
});


$factory->state(App\User::class, 'unconfirmed', function () {
    return [
        'confirmed' => false
    ];
});

$factory->state(App\User::class, 'administrator', function () {
    $first_name = 'john';
    $last_name = 'Doe';
    return [
        'name' => $first_name. " ".$last_name,
        'first_name' => $first_name,
        'last_name'     =>  $last_name
    ];
});




$factory->define(App\Thread::class, function ($faker) {
    $title = $faker->sentence;

    return [
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'channel_id' => function () {
            return random_int(1,10);
        },
        'title' => $title,
        'body'  => $faker->paragraph,
        'visits' => 0,
        'slug' => str_slug($title),
        'locked' => false,
        'image_path'    =>  'https://source.unsplash.com/random'
    ];
});

$factory->define(App\Tags::class, function ($faker) {

    return [
        'name' => $faker->unique()->word,
    ];
});


$factory->define(App\Channel::class, function ($faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name
    ];
});


$factory->define(App\Reply::class, function ($faker) {
    return [
        'thread_id' => function () {
            return factory('App\Thread')->create()->id;
        },
        'user_id' => function () {
            return factory('App\User')->create()->id;
        },
        'body'  => $faker->paragraph
    ];
});

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function ($faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
            return auth()->id() ?: factory('App\User')->create()->id;
        },
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar']
    ];
});


$factory->define(App\Admin::class, function ($faker) {
    return [
        'app_name'   => 'Anecdotage',
        'faq'   => $faker->paragraph,
        'tos'   =>  $faker->paragraph,
        'privacypolicy' =>  $faker->paragraph,
        'mail_driver' =>  'smtp',
        'mail_host' =>  'smtp.mailtrap.io',
        'mail_port' =>  '2525',
        'username' => 'efbb6d7afb6d71' ,
        'password' =>  '89ef77196e6267',
        'mail_encryption' =>  'tls',
        'copyright'     =>  'Copyright &copy; anecdotage.com',
        'timezone'      =>  'America/New_York'
    ];
});