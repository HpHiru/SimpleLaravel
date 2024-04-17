<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Mail;
class LoginController extends Controller
{

    use AuthenticatesUsers;



    public function showLoginForm()
    {
        $userId = @\Auth::user()->id?:"";
        if($userId > 0){
            return redirect()->route('home');
        }
        return view('login');
    }

    public function sendEmailOtp(Request $request){
        try {
            //code...
            $email = $request->email;
            $otp = mt_rand(1000, 9999);
            $data = ['email' => $email,'otp' => $otp,'from_email' => env('MAIL_FROM_ADDRESS')];
            // Send OTP email
            $mailSent = \Mail::send('email-template', $data, function ($message) use ($data) {
    
                $message->to($data['email'], 'Login OTP')->subject('You have have recieved login otp!');
    
                $message->from($data['from_email'], 'Login OTP');
            });
            $emailExpload = explode('@',$email);
            $user = User::where('email',$email)->first();
            if(empty($user)){
                $user = new User ();
            }
            $user->name = @$emailExpload[0]?:"";
            $user->email = @$email?:"";
            $user->password = @$otp?:"";
            $user->save();

            
            return response()->json(['status' => 1, 'message' => 'OTP sent successfully! Please check your email.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => 'Sonthing went wrong pls try again!.']);
        }

    }

    public function loginCheck(Request $request)
    {
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('otp') ])) {
            // $userId = Auth::user()->id;
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function logout()
    {
        \Auth::logout();
        return redirect()->route('showLoginForm');
        Session::flush();
    }
}
