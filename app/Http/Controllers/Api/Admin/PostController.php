<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Post, category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:superadministrator');
    // }
    public function index()
    {
        $posts = Post::with(['user', 'categories'])->paginate(10);
        return response()->json([
            'posts' => $posts, 'categories' => Category::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->all();
        $this->validate($request, [
            'images' => 'required',
            'images.type' => 'image|mimes:jpeg,png',
            'title' => 'required|string',
            'title' => 'required|min:3',
            'body' => 'required|string',
            'categories' => 'required|distinct|min:1'
        ]);
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $request->slug,
            'title' => $request->title,
            'user_id' => \Auth::user()->id
        ]);
        $categories = json_encode($request->categories);
        $categories = str_replace('"', "", $categories);
        $categories = str_replace(',', "", $categories);
        $categories = str_split($categories);
        $count = count($categories);
        for ($i = 0; $i < $count; $i++) {
            $categories[$i] = (int)$categories[$i];
        }
        $post->categories()->attach($categories);
        $files = $request->images;
        upload_images($files, $post);

        $files = $request->images;
    }


    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        // return $id;
        $this->validate($request, [
            'slug' => 'required|string|min:3',
            'title' => 'required|string|min:3',
            'body' => 'required|string',
            'categories' => 'required|distinct|min:1'
        ]);
        try {
            $post = Post::find($id)->first();
            $this->requestsProcessing($post, $request);
        } catch (\Throwable $th) {
            return $th;
        }
        // return $request->all();
        // dd($post);
    }

    private function requestsProcessing($post, $request)
    {
        !empty($request->image) ?? upload_images($request->image, $post);
        $post->update($request->except(['image', 'categories']));
        $categories = json_encode($request->categories);
        $categories = str_replace('"', "", $categories);
        $categories = str_replace(',', "", $categories);
        $categories = str_split($categories);
        $count = count($categories);
        for ($i = 0; $i < $count; $i++) {
            $categories[$i] = (int)$categories[$i];
        }
        $post->categories()->attach($categories);
    }
    public function destroy(Request $r)
    {
        $posts = Post::whereIn('id', $r->posts_ids)->get();
        foreach ($posts as $post) {
            $post->delete();
        }
    }
}
