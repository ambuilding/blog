<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;

class CommentsController extends Controller
{
    public function store(Post $post)
    {
    	$post->addComment(request('body'));
    	// add a comment to a post

    	return back();
    }
}
