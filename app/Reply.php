<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use DB;

class Reply extends Model
{
    use Favoritable, RecordsActivity, Notifiable;

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['owner', 'favorites'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['favoritesCount', 'isFavorited', 'isBest','isReported','replyCount','ownerThreadUrl'];

    /**
     * Boot the reply instance.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    /**
     * A reply has an owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A reply belongs to a thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Determine if the reply was just published a moment ago.
     *
     * @return bool
     */
    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    /**
     * Fetch all mentioned users within the reply's body.
     *
     * @return array
     */
    public function mentionedUsers()
    {
//        preg_match_all('/@([\w\-]+)/', $this->body, $matches);


            preg_match_all('/@(?<=@)[a-zA-Z]+\s[a-zA-Z]+/', $this->body, $matches);
            $name = substr($matches[0],1);

            return $name;
        //dd($matches);
        return $matches[1];
    }

    /**
     * Determine the path to the reply.
     *
     * @return string
     */
    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    /**
     * Set the body attribute.
     *
     * @param string $body
     */
    public function setBodyAttribute($body)
    {
        $line = preg_replace_callback(
//            '/@([\w\-]+)/',
            '/@(?<=@)[a-zA-Z]+\s[a-zA-Z]+/',

            function ($matches) {
                //return strtolower($matches[0]);
                //return $matches[1];
                $name = substr($matches[0],1);
               // return $name;

                 $user = User::where( 'name', $name)->first();
                if($user){
                    return "<a href=\"/profiles/".$user->username."\">".$matches[0]."</a>";
                }else{
                    return $matches[0];
                }


            },
            $body
        );

        $this->attributes['body'] = $line;

        //Currently Working

//        $replace =
//            preg_replace(
//            '/@([\w\-]+)/',
//            '<a href="/profiles/$1">$0</a>',
//            $body
//        );
//        $this->attributes['body'] = $replace;
    }

    /**
     * Determine if the current reply is marked as the best.
     *
     * @return bool
     */
    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    /**
     *
     * Determine if the current reply is marked as the best.
     *
     * @return bool
     */
    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    /**
     * Access the body attribute.
     *
     * @param  string $body
     * @return string
     */
    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }

//    public function favorites()
//    {
//        return $this->morphMany(Favorite::class, 'favorited');
//    }

    public function getIsReportedAttribute()
    {
        $report = DB::table('reports')
            ->where('user_id', auth()->id())
            ->where('reported_id', $this->id)
            ->where('reported_type','App\Reply')
            ->first();
        ;
        if($report){
            return true;
        }else{
            return false;
        }

    }

    public function getReplyCountAttribute(){
        return $this->replyCount();
    }
    public function replyCount(){
        $reply = DB::table('replies')
            ->where('parent_id', $this->id)->get()->count()
            //->get();
        ;
    }

    public function getOwnerThreadUrlAttribute(){
        return url('threads?by='.$this->owner->username);
    }
}
