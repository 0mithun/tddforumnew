<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $guarded = [];



    protected static function boot()
    {
        parent::boot();

        static::updated(function ($admin) {
            config()->set('app_name', $admin->app_name);
            config()->set('mail_driver', $admin->mail_driver);
            config()->set('mail_host', $admin->mail_host);
            config()->set('mail_port', $admin->mail_port);
            config()->set('username', $admin->username);
            config()->set('password', $admin->password);
            config()->set('mail_encryption', $admin->mail_encryption);
            config()->set('copyright', $admin->copyright);
            config()->set('timezone', $admin->timezone);
        });
    }
}
