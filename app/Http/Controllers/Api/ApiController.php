<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
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

    public function login(Request $request){

        $request ->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where("email", $request->email)->first();

        if(!empty($user)){

            if(Hash::check($request->password, $user->password)){

                $token = $user->createToken("myToken")->plainTextToken;
                return response()->json([
                    "status"=>true,
                    "message" => "Login successfully",
                    "token" => $token
                ]);

            }
           return response()->json([
            "status" => false,
            "message" => "Invalid password"
           ]);
        }
        return response()->json([
            "status" =>false,
            "message" => "Invalid user creadentials"
        ]);

    }

    public function profile(){

        $data = auth()->user();
        return response()->json([
            "status" =>true,
            "message" => "Profile data fetched successfully",
            "data"=>$data
        ]);

    }
    public function logout(){

        auth()->user()->tokens()->delete();
        return response()->json([
            "status"=>true,
            "message" => "Logged out successfully"
        ]);

    }
}
