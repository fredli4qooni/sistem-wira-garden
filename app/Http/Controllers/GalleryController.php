<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = \App\Models\Gallery::where('is_active', true)->orderBy('sort_order')->get();
        return view('galleries.index', compact('galleries'));
    }
}
