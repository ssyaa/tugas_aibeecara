<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use illuminate\Support\Facades\Hash;
use illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class jwtAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
        'name' => $request-get('name'),
        'email' => $request-get('email'),
        'password' => Hash::make($request->get('password')),
    ]);

    $token = JWTAuth::fromUser($user);

    return response()->json(compact('user','token'),201);}
}

public function login (Requesu $request)
{
    $credentials = $request->only('email','password');

    try {
        if(! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid Credentials', 401]);
        }

        $user = auth()->user();
        $token = JWTAuth::claims(['role' = $user->role])->fromUser($user);
        return response()->json(compact('token'));
    } catch (JWTException $e) {
        return response()-->json(['error' => 'Could n'])
    }
}