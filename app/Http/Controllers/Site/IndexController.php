<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('site.main.index');
    }
}
