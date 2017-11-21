<?php

namespace App\Repositories;

use App\Post;
use App\Redis;

class Posts {
	protected $redis;

	function __construct(Redis $redis)
	{
		$this->redis = $redis;
	}

	public function all()
	{
		//return Post::all();
		return Post::latest()
        	->filter(request(['month', 'year']))
        	->get();
	}

	public function search($query)
    {
        return Post::where('title', 'LIKE', "%$query%")
            ->orWhere('body', 'LIKE', "%$query%")
            ->orderBy('created_at', 'desc')
            ->get();
    }

	public function find()
	{

	}
}
