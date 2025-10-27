<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $rules = [
            'role' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:16',
        ];

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password) || $user->role != $request->role){
            return redirect()->back()
                ->with('error', "Invalid Credentials");
        }

        $payload = [
            'iss' => 'your-app-name',
            'sub' => $user->id,                
            'email' => $user->email,     
            'iat' => time(),            
            'exp' => time() + (30 * 60)        
        ];

        $jwt = JWT::encode($payload, env('APP_KEY'), 'HS256');
        
        PersonalAccessToken::create([
            'user_id' => $user->id,
            'token' => $jwt,
            'expires_at' => now()->addMinutes(30),
        ]);

        if($user->role == "admin"){
            return redirect()->route('admin-dashboard')->withCookie(cookie('token', $jwt, 30));
        }
        else{
            return redirect()->route('student-dashboard')->withCookie(cookie('token', $jwt, 30));
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:16',
        ]);

        User::create([
            'role' => 'student',
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
}
