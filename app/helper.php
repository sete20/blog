<?php
if (!function_exists('upload_images')) {
    function upload_images($image, $post)
    {
        $path = public_path('img/posts/' . $post->poster);
        if (file_exists($path)) {
            $post->photos()->delete();
            \File::delete($path);
            $filename = '';
            $file = $image;
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/posts'), $filename);
            $post->photos()->create(['path' => $filename]);
        }
        // dd($image);
        // }
    }
}
