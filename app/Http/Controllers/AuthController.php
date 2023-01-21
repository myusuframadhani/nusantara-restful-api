<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);

        $validateData['password'] = Hash::make($request->password);

        $user = User::create($validateData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request) {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid credentials'], 400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()-> 
        user(), 'access_token' => $accessToken]);
    }
}
