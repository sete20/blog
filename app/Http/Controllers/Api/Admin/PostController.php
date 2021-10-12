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
        // $this->validate($request, [
        //     'images' => 'required|array',
        //     'images.type' => 'image|mimes:jpeg,png',
        //     'images.length' => 'min:1',
        //     'title' => 'required|string',
        //     'body' => 'required|string',
        //     'categories' => 'required|distinct'
        // ]);
        // return $request->images;
        // return    json_decode($request->images);
        if ($request->has('images')) {
            $filename = '';
            $files = $request->images;
            foreach ($files as $file) {
                // here is your file object
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/posts'), $filename);
                return "done";
            }
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
