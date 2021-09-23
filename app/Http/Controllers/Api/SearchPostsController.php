<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchPostsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($q)
    {
        $posts = Post::SearchPosts($q)->with('user')->paginate(10);
        foreach ($posts as $post) {
            $post->setAttribute('added_at', $post->created_at->diffForHumans());
            $post->setAttribute('comments_count', $post->comments->count());
        }
        return response()->json(
            [
                'posts' => $posts
            ]
        );
    }
}
