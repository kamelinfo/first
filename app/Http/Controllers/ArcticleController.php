<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArcticleController extends Controller
{
    function show($n)  {
        return view('article')->with('numero',$n);
    }
}
