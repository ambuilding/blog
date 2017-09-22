<?php

namespace App\Providers;

use App\Billing\Stripe;
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
        // \View::composer()
        view()->composer('layouts.sidebar', function ($view) {
            $archives = \App\Post::archives();
            $tags = \App\Tag::has('posts')->pluck('name');
            $view->with(compact('archives', 'tags'));
            // $view->with('archives', \App\Post::archives());
            // $view->with('tags', \App\Tag::pluck('name'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Service container \App::
        $this->app->singleton(Stripe::class, function () {
            return new Stripe(config('services.stripe.secret'));
        });
        //bind to this container bind/singleton
    }
}
