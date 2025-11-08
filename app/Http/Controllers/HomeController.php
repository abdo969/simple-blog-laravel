<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $featuredPosts = Cache::remember('featured_posts', now()->addHours(12), function () {
            return Post::published()->featured()->with("categories")->latest('published_at')->take(3)->get();
        });
        $latestPosts = Cache::remember('latest_posts', now()->addHours(1), function () {
            return Post::published()->with("categories")->latest('published_at')->take(9)->get();
        });

        return view('home', [
            'featured_posts' => $featuredPosts,
            'latest_posts' => $latestPosts,
        ]);
    }
}
