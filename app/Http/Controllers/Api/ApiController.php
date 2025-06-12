<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiController extends Controller
{
    //Register API(POST)
    public function register(Request $request) {

        $request ->validate([

            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"

        ]);

        User::create([
            "name" => $request->name,
            "email" => $request -> email,
            "password" => Hash::make($request->password)
        ]);

       return response()->json([
        "status" =>true,
        "message" => "User registerd successful"
       ]);

    }

    // Login Api (POST)

    public function login(Request $request){

    }

    // profile Api (GET)

    public function profile(){

    }


    //  Logout Api(Get)
    public function logout(){

    }
}
