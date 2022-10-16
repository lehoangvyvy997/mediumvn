<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        try {
            $user->save();
            $token = $user->createToken('API Token')->accessToken;
        } catch (\Throwable $th) {
            throw $th;
        }
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = ['email' => $request->email, 'password' => $request->password];
        if(!auth()->attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
