<?php

namespace App;

use Carbon\Carbon;

class Post extends Model
{
	public function comments() {
		return $this->hasMany(Comment::class); // App\Comment
	}

	public function user() { // $comment->post->user
    	return $this->belongsTo(User::class);
    }

	public function addComment($body) {
		$this->comments()->create(compact('body'));
    	// Comment::create([
    	// 	'body' => $body,
    	// 	'post_id' => $this->id
    	// ]);
    }

    public function scopeFilter($query, $filters)
    {
    	if ($month = $filters['month']) {
            $query->whereMonth('created_at', Carbon::parse($month)->month);
        }

        if ($year = $filters['year']) {
            $query->whereYear('created_at', $year);
        }
    }

    // public function scopeSearch($query, $search)
    // {
    //     return $query->where('title', 'LIKE', "%$search%")
    //         ->orWhere('body', 'LIKE', "%$search%");
    // }

    public static function archives()
    {
    	return static::selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')
        ->orderByRaw('min(created_at) desc')
        ->groupBy('year', 'month')
        ->get()
        ->toArray();
    }

    public function tags()
    {
        // 1 post may have many tags
        // any tag may be applied to many posts
        return $this->belongsToMany(Tag::class);
    }
}
