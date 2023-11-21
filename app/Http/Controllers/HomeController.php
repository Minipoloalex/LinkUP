<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        return view('pages.home');
    }
}