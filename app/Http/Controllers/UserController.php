<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user');
    }

/*public function logout(request $request){
    Auth::user()->name ::logout();
    return redirect ('/login');
}*/
}
