<?php

namespace App\Http\Controllers;

use App\Tutorial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function laravel_vapor()
    {
        return view('layouts.tutorial-laravel_vapor');
    }
}
