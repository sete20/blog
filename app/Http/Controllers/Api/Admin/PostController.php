<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Post, category};
use Illuminate\Http\Request;

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
        // dd($request->all());
        // $categories = json_encode($request->categories);
        $categories = json_encode($request->categories);
        $categories = str_replace('"', "", $categories);
        $categories = str_replace(',', "", $categories);
        $categories = str_split($categories);
        $count = count($categories);
        for ($i = 0; $i < $count; $i++) {
            $categories[$i] = (int)$categories[$i];
        }
        $post->categories()->attach($categories);
        if ($request->hasFile('images')) {
            $files = $request->images;
            foreach ($files as $file) {
                // here is your file object
                dd($file->getClientOriginalName());
            }
        } else {
            return 0;
        }
        // dd($phpArray = json_decode($request->images[0], true));
        // $name = $phpArray['name'];
        // $coach = $phpArray['coach'];
        // $coach_uuid = $phpArray['coach']['uuid'];
        // $category = $phpArray['category'];
        // $category_uuid = $phpArray['category']['uuid];
        // if ($request->images) {
        //     $files = $request->images;
        //     foreach ($files as $file) {
        //         // here is your file object
        //         dd($file->getClientOriginalName());
        //     }
        //     // return $request->images;
        //     return json_decode($request->images);
        upload_images($request->images, $post);
        //     // return $request->images;
        // } else {
        // }

        if ($request->has('images')) {
        }
        // foreach ($files as $file) {
        //     // here is your file object
        //     return ($file->getClientOriginalName());
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
