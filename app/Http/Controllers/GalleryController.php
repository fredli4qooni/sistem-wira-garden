<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $destinations = \App\Models\Destination::all();
        $galleries = collect();
        foreach ($destinations as $dest) {
            if (is_array($dest->gallery_images)) {
                foreach ($dest->gallery_images as $path) {
                    $galleries->push((object)[
                        'image_path' => $path,
                        'title' => $dest->name,
                        'category' => $dest->category ? $dest->category->name : 'Lainnya',
                        'icon' => $dest->category ? $dest->category->icon_value : null,
                        'icon_type' => $dest->category ? $dest->category->icon_type : null
                    ]);
                }
            }
        }
        $galleries = $galleries->shuffle();
        return view('galleries.index', compact('galleries'));
    }
}
