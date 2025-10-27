<?php

namespace App\Http\Controllers;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentDashboard extends Controller
{
    public function dashboard(Request $request){
        $tokenString = $request->cookie('token');

        $personal_access_token = DB::table('personal_access_tokens')->where('token',$tokenString)->where('expires_at', '>', now())->first();
        
        if(!$personal_access_token){
            return redirect()->back()->with('error', "Token Expired");
        }

        $users = User::where('id',$personal_access_token->user_id)->first();

        $data = [
            'title' => "Student Form",
            'users' => $users,
            'token' => $tokenString, 
        ];
        
        return view('student.examform',$data);
    }

    protected $api;

    public function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    }

    public function createOrder(Request $request)
    {
        if (!$request->expectsJson()) {
            return response()->json(['message' => 'Invalid Request'], 400);
        }


        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'plan' => 'required|string',
            'amount' => 'required|integer'
        ]);

        try {
            $order = $this->api->order->create([
                'receipt' => 'order_rcpt_' . Str::random(6),
                'amount' => $data['amount'],
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            return response()->json([
                'order_id' => $order['id'],
                'amount' => $order['amount'],
                'currency' => $order['currency'],
                'key' => env('RAZORPAY_KEY_ID')
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay order error: ' . $e->getMessage());
            return response()->json(['message' => 'Unable to create Razorpay order.'], 500);
        }
    }

    public function verify(Request $request)
    {
        $data = $request->validate([
                'razorpay_payment_id' => 'required|string',
                'razorpay_order_id' => 'required|string',
                'razorpay_signature' => 'required|string',
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'plan' => 'required|string',
            ]);

        try {
            $tokenString = $request->cookie('token');
            $personal_access_token = DB::table('personal_access_tokens')->where('token',$tokenString)->where('expires_at', '>', now())->first();
            
            if(!$personal_access_token){
                return redirect()->back()->with('error', "Token Expired");
            }

            $users = User::where('id',$personal_access_token->user_id)->first();


            $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            $pdfData = [
                'name' => $request->name,
                'email' => $request->email,
                'amount' => '₹500.00',
                'payment_id' => $request->razorpay_payment_id,
            ];

            $pdf = Pdf::loadView('pdf.receipt', $pdfData);
            $fileName = 'payment_receipt_' . time() . '.pdf';
            $pdf->save(public_path('receipts/' . $fileName));

            DB::table('payments')->insert([
                    'user_id' => $users->id,
                    'phone' => $data['phone'],
                    'order_id' => $data['razorpay_order_id'],
                    'payment_id' => $data['razorpay_payment_id'],
                    'signature' => $data['razorpay_signature'],
                    'pdf' => $fileName,
                    'amount' => 50000,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully!',
                'pdf_url' => asset('receipts/' . $fileName),
            ]);

        } catch (\Exception $e) {
            Log::error('Payment verification failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Payment verification failed!'], 400);
        }
    }
}
