<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'avatar_path',
        'city',
        'country',
        'about'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'confirmed' => 'boolean'
    ];

    protected $appends = ['isReported','profileAvatarPath'];

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    protected static function boot()
    {
        parent::boot();

//        static::deleting(function ($thread) {
//            $thread->replies->each->delete();
//        });

        static::created(function ($user) {
            $user->usersetting()->create([
                'mention_notify_anecdotage'                     =>  1,
                'mention_notify_email'                          =>  0,
                'mention_notify_facebook'                       =>  0,
                'new_thread_posted_notify_anecdotage'           =>  1,
                'new_thread_posted_notify_email'                =>  0,
                'new_thread_posted_notify_facebook'             =>  0,
                'receive_daily_random_thread_notify_anecdotage' =>  1,
                'receive_daily_random_thread_notify_email'      =>  0,
                'receive_daily_random_thread_notify_email'      =>  0,
            ]);
        });
    }


    /**
     * Fetch all threads that were created by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * Fetch the last published reply for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    /**
     * Get all activity for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Mark the user's account as confirmed.
     */
    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;

        $this->save();
    }

    /**
     * Determine if the user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return auth()->id() == 1;
    }

    public function getIsAdminAttribute(){
        return $this->isAdmin();
    }

    public function getNameAttribute(){
        return ucfirst($this->first_name) ." ".ucfirst($this->last_name);
    }


    /**
     * Record that the user has read the given thread.
     *
     * @param Thread $thread
     */
    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }

    /**
     * Get the path to the user's avatar.
     *
     * @param  string $avatar
     * @return string
     */
     public function getAvatarPathAttribute($avatar)
     {
         return $avatar ?: 'images/avatars/default.png';
     }

    public function getProfileAvatarPathAttribute($avatar){
        return asset($avatar ?: 'images/avatars/default.png');
    
    }
    

    /**
     * Get the cache key for when a user reads a thread.
     *
     * @param  Thread $thread
     * @return string
     */
    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }


    public function getIsReportedAttribute()
    {
        $report = DB::table('reports')
            ->where('user_id', auth()->id())
            ->where('reported_id', $this->id)
            ->where('reported_type','App\User')
            ->first();
        ;
        if($report){
            return true;
        }else{
            return false;
        }

    }

    public function getFullNameAttribute(){
        return $this->first_name. ' '. $this->last_name;
    }

   public function usersetting(){
        return $this->hasOne(Usersetting::class);
   }

}
