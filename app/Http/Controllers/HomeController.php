<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $clubs = Club::latest()->get();

        return view('index', compact('clubs'));
    }
}
