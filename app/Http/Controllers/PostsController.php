<?php

namespace App\Http\Controllers;

use App\Post;
use App\Repositories\Posts;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Posts $posts)
    {
        $query = request('q');

        $posts = $query
            ? $posts->search($query)
            : $posts->all();
        //return session('message');

        //dd($posts);
        //$posts = (new Posts)->all();
/*
        $posts = Post::latest()
        ->filter(request(['month', 'year']))
        ->get();
*/
        //$posts = Post::all();
        //$posts = Post::latest(); //->get();
        //$posts = Post::orderBy('created_at', 'asc')->get();

        // if ($month = request('month')) {
        //     $posts->whereMonth('created_at', Carbon::parse($month)->month);
        // }

        // if ($year = request('year')) {
        //     $posts->whereYear('created_at', $year);
        // }

        // $posts = $posts->get();

        // temporary
        //$archives = Post::

        //return $archives;
    	return view('posts.index', compact('posts'));
        //return view('posts.index')->with('posts', $posts);
    }

    // public function show($id)
    // {
    //     $post = Post::find($id);
    // 	return view('posts.show', compact('post'));
    // }

    // route model binding
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
    	return view('posts.create');
    }

    public function store()
    {
    	//dd(request()->all());
    	//request('title') / request(['title', 'body'])
    	// create a new post using the request data
    	// $post = new Post;
    	// $post->title = request('title');
    	// $post->body = request('body');
    	// save it to the database
    	// $post->save();

    	// Post::create([
    	// 	'title' => request('title'),
    	// 	'body' = > request('body')
    	// ]);

        $this->validate(request(), [
            'title' => 'required',
            'body' => 'required'
        ]);

        auth()->user()->publish(new Post(request(['title', 'body'])));

    	//Post::create(request(['title', 'body', 'user_id']));

        session()->flash('message', 'Your post has now been published.');

        // flash('Your message here')

    	// and then redirect to the home page
    	return redirect('/');
    }
}
