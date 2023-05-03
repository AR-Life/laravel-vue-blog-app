<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->access_token = $user->createToken($user)->plainTextToken;
        return response()->json(['user' => $user]);
    }
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(["message" => "E-Posta adresi veya parola hatalı"], 400);
    }
 
    $user->access_token = $user->createToken($user)->plainTextToken;
    return response()->json(['user' => $user]);

}
public function logout(Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Çıkış Yapıldı']);
}

}