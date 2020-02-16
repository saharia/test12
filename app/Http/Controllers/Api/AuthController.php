<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request) {
      // echo "test";die;
      $validated_data = $request->validate([
        "name" => "required|max:55",
        "email" => "email|required|unique:users",
        "password" => "required|confirmed",
        "role" => "required"
      ]);

      $validated_data['password'] = bcrypt($validated_data['password']);

      $user = User::create($validated_data);

      $access_token = $user->createToken('authToken')->accessToken;

      return response([ 'user' => $user, 'access_token' => $access_token ]);
    }

    public function login(Request $request) {
      $login_data = $request->validate([
        "email" => "email|required",
        "password" => "required"
      ]);

      if(!auth()->attempt($login_data)) {
        return response([ "msg" => "invalid credentials" ], 401);
      }

      $access_token = auth()->user()->createToken('authToken')->accessToken;
      return response([ 'user' => auth()->user(), 'access_token' => $access_token ]);
    }
}
