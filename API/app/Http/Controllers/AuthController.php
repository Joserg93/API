<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $email = $request->only('email');
        try {
            $user = User::where('email', '=', $email)->first();
            return response()->json(($user->id), 200);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
    }

    public function auth_email(Request $request)
    {
        $email = $request->only('email');
        $email = str_ireplace('"','',$email);
        try {
            $user = User::where('email', '=', $email)->first();
            if($user==null){
                return response()->json(['No existe...'],200);
            }else{
                return response()->json(['error' => 'existe'],401);
            }
            
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'aplication'], 500);
        }
    }

    public function getAuthUser(){
        return response()->json(['valid'],200);  
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json($token);
    }

}
