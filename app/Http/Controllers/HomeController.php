<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $destinations = \App\Models\Destination::limit(3)->get();
        return view('welcome', compact('destinations'));
    }

    public function about()
    {
        return view('about');
    }
}
