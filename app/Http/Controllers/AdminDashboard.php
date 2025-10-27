<?php

namespace App\Http\Controllers;

use App\Models\PersonalAccessToken;
use App\Models\User;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Controller
{
    public function dashboard(Request $request){
        $tokenString = $request->cookie('token');
        
        $personal_access_token = DB::table('personal_access_tokens')->where('token',$tokenString)->where('expires_at', '>', now())->first();
        
        if(!$personal_access_token){
            return redirect()->back()->with('error', "Token Expired");
        }

        $users = User::where('id',$personal_access_token->user_id)->first();
        $payments = Payments::with('user')->get();

        $data = [
            'users' => $users,
            'token' => $tokenString,
            'payments' => $payments, 
        ];
        
        return view('admin.examform',$data);
    }
}
