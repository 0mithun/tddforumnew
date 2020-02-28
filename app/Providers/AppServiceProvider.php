<?php

namespace App\Providers;

use App\Admin;
use App\Channel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function ($view) {
            $channels = \Cache::rememberForever('channels', function () {
                return Channel::all();
            });

            $view->with('channels', $channels);
        });

        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');

        $admin = Admin::first();

        if($admin){

            config()->set('app_name', $admin->app_name);
            config()->set('mail_driver', $admin->mail_driver);
            config()->set('mail_host', $admin->mail_host);
            config()->set('mail_port', $admin->mail_port);
            config()->set('username', $admin->username);
            config()->set('password', $admin->password);
            config()->set('mail_encryption', $admin->mail_encryption);
            config()->set('copyright', $admin->copyright);
            config()->set('timezone', $admin->timezone);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
