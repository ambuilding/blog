<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
	use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        //$this->assertTrue(true);
        // given I have two records in the datatbase that are posts,
        // and each one is posted a month apart
    	$first = factory(Post::class)->create();
    	$second = factory(Post::class)->create([
    		'created_at' => \Carbon\Carbon::now()->subMonth()
    	]);
        // whnen I fetch the archives
    	$posts = Post::archives();

        // then the response should be in the proper format
        $this->assertEquals([
        	[
        		"year" => $first->created_at->format('Y'),
    			"month" => $first->created_at->format('F'),
    			"published" => 1
        	],
        	[
        		"year" => $second->created_at->format('Y'),
    			"month" => $second->created_at->format('F'),
    			"published" => 1
        	],
        ], $posts);
        //$this->assertCount(2, $posts);
    }
}
