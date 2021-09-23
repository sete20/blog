<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Post, Category, User};

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->paginate(10);
        $categories = Category::whereHas('posts')->paginate(10);
        foreach ($posts as $post) {
            $post->setAttribute('added_at', $post->created_at->diffForHumans());
            if ($post->photos->isNotEmpty()) {
                $post->setAttribute('poster', $post->photos->path->first());
            }
            $post->categories->first();
            $post->setAttribute('comments_count', $post->comments->count());
        }

        return response()->json(['posts' => $posts, 'categories' => $categories]);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        return response()->json(
            [
                'post' => [
                    'id' => $post->id,
                    'slug' => $post->slug,
                    'body' => $post->body,
                    'added_at' => $post->created_at->diffForHumans(),
                    'posters' => $post->photos,
                    'user' => $post->user,
                    'title' => $post->title,
                    'comments_count' => $post->comments->count(),
                    'categories' => $post->categories,
                    // count($post->comments) != 0 ??
                    'comments' => $this->commentFormatted($post->comments),
                ], 'categories' => Category::get()

            ]
        );
    }

    private function commentFormatted($comments)
    {
        $newComments = [];
        foreach ($comments as $comment) {
            array_push($newComments, [
                'id' => $comment->id,
                'body' => $comment->body,
                'created_at' => $comment->created_at->diffForHumans(),
                'user' => $comment->user,

            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
