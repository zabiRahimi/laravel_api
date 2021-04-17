<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        #validate
        $this->validate($request ,[
            'email'=> 'required|email|exists:users',
            'password'=> 'required',
        ]);
        return 'shod';
    }

    public function register(Request $request)
    {
        # code...
    }
}
