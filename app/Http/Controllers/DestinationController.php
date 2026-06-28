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

    public function show($id)
    {
        $destination = \App\Models\Destination::findOrFail($id);
        $facilities = [];
        if (is_array($destination->facilities) && count($destination->facilities) > 0) {
            $facilities = \App\Models\Facility::whereIn('id', $destination->facilities)->get();
        }
        return view('destinations.show', compact('destination', 'facilities'));
    }
}
