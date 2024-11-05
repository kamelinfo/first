<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function create()  {
   
        return view('info');
    }
    function store(Request $request)  {

        $this->validate($request,[
            'nom'=>'required|alpha',
            'email'=>'required|email',
        ]);
        return 'le nom est '.$request->input('nom');
    }
}
