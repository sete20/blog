<?php
if (!function_exists('upload_images')) {
    function upload_images($image, $post)
    {

        // dd($image);
        $filename = '';
        $file = $image;
        // foreach ($files as $file) {
        // here is your file object
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('img/posts'), $filename);
        return "done";
        // }
    }
}
