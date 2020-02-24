<?php


namespace App;


trait Likeable
{


    public function like()
    {
        $attributes = [
            'user_id' => auth()->id(),
           // 'up' => 1
        ];

        if (!$this->likes()->where($attributes)->exists()) {
            return $this->likes()->create($attributes);
        }
    }

    public function unlike(){
        $attributes = [
            'user_id' => auth()->id(),
            //'up' => 1
        ];

        $this->likes()->where($attributes)->delete();
    }

    public function likes()
    {
        return $this->morphMany(Likes::class, 'likeable');
    }

    public function getIsLikedAttribute()
    {
        return $this->isLiked();
    }

    public function isLiked()
    {
        return !!$this->likes->where('user_id', auth()->id())->count();
    }


    public function getLikesCountAttribute(){
        return $this->likes()->count();
    }
}