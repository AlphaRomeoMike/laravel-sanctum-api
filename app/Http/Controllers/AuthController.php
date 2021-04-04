<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email'     => 'required|string',
            'password'  => ''
        ]);

        $user = User::where('email', $fields['email'])->first();
        
        if(!$user || !Hash::check($fields['password'], $user->password))
        {
            return response([
                'message' => 'Wrong credentials'
            ],401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user'      => $user,
            'token'     => $token
        ];

        return response($response, 201);
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|string|unique:users,email',
            'password'  => 'required|confirmed'
        ]);

        $user = User::create([
            'name'      => $fields['name'],
            'email'     => $fields['email'],
            'password'  => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user'      => $user,
            'token'     => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
