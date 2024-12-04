<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordRecovery;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Mail; 
use App\Models\User;
use Error;

class RecoveryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Recovery Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after Recovery.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showRecoveryForm()
    {
        // needed to redirect to previous page
        $loggedIn = Auth::check();
        if(!session()->has('url.intended'))
            session(['url.intended' => url()->previous()]);
            
        return view('auth.recovery',['loggedIn' => $loggedIn,'sent' => 0]);
    }

    public function sendRecoverEmail(Request $request){
        $request->validate([

            'email' => 'required|email|exists:User',

        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([

            'email' => $request->email, 

            'token' => $token, 

            'created_at' => Carbon::now()

          ]);
          $user = User::where('email', $request->email);
        Mail::to($request->email)->send(new PasswordRecovery($token));
/*         Mail::send('emails.recover_password', ['token' => $token], function($message) use($request){

            $message->to($request->email);

            $message->subject('Reset Password');

        }); */
        $loggedIn = Auth::check();
        return view('auth.recovery',['loggedIn' => $loggedIn,'sent' => 1])->with('message', 'We have e-mailed your password reset link!');
    }

    public function showResetPassword(Request $request) {
        $loggedIn = Auth::check();
        if(!session()->has('url.intended'))
            session(['url.intended' => url()->previous()]);

        return view('auth.reset_password', ['token' => $request->token, 'loggedIn' => $loggedIn]);
    }

    public function sendResetForm(Request $request){
        $request->validate([
            'email' => 'required|email|exists:User',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        $updatePassword = DB::table('password_resets')

                            ->where([

                              'email' => $request->email, 

                              'token' => $request->token

                            ])

                            ->first();
        if(!$updatePassword){
            $loggedIn = Auth::check();
            return view('auth.reset_password', ['token' => $request->token, 'loggedIn' => $loggedIn, 'passwordreset' => 'false']);
 
        }
        $user = User::where('email', $request->email)

                    ->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        return view('auth.login',['passwordreset' => true])->with('message', 'Your password has been changed!');
    }

    public function getUser(){
        return $request->user();
    }

    public function home() {
        return redirect('login/reset');
    }

}
