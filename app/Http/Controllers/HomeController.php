<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $ticketTypes = \App\Models\TicketType::where('is_active', true)->get();
        return view('welcome', compact('ticketTypes'));
    }
}
