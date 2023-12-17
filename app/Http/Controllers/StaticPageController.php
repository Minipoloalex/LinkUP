<?php

namespace App\Http\Controllers;

class StaticPageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function features()
    {
        return view('pages.features');
    }
}