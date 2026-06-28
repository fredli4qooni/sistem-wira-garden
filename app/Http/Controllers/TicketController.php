<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;

class TicketController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        return view('tickets.index', compact('destinations'));
    }
}
