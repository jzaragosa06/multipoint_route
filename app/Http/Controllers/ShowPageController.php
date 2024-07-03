<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowPageController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function landing()
    {
        return view('landing');
    }
}
