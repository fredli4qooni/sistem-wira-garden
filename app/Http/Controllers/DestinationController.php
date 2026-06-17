<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = \App\Models\Destination::all();
        return view('destinations.index', compact('destinations'));
    }
}
