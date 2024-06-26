<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function reg(registerRequest $request)
    {
        $user = User::create($request->validated());
        $user->api_token = $user->createToken('api_token')->plainTextToken;
        $user->save();

        return response([
            "success" => true,
            "message" => "Success",
            "token" => $user->api_token,
        ]);
    }
    public function login(LoginRequest $request)
    {
        $user = auth()->attempt($request->validated());
        if (!$user) {
            return response([
                "success" => false,
                "message" => "Login failed",
            ], 401);
        }

        $user = auth()->user();
        $user->api_token = $user->createToken('api_token')->plainTextToken;
        $user->save();

        return response([
            "success" => true,
            "message" => "Success",
            "token" => $user->api_token
        ]);
    }
    public function logout()
    {
        $user = auth()->user();
        $user->api_token = '';
        $user->save();
        return response([
            "success" => true,
            "message" => "Logout",
        ]);
    }
}
