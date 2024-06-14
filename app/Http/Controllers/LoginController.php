<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'msg' => 'Validation error', 'data' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
          return response()->json(['status' => 'error', 'msg' => 'Invalid Credentails'], 401);
        }

           return response()->json([
            'status' => 'success',
            'msg' => 'login successful',
            'data' => ['user_details' => Auth::user(),'token' => $token]
        ],200);
    }
}

