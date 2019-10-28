<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $previous_session = Auth::User()->session_id;
        if ($previous_session) {
            \Session::getHandler()->destroy($previous_session);
        }

        Auth::user()->session_id = \Session::getId();
        Auth::user()->save();
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /*public function validateLogin(Request $request)
    {
      //  $this->validate($request,
      //    [ $this->username() => [ 'required', Users::where(function ($query) { $query->where('estado', 'A'); }), ],
      //        'password' => 'required' ]);

       $this->validate($request, [ $this->username() => 'required|exists:users,' . $this->username() . ',estado,A', 'password' => 'required', ]);

    }*/

    public function username()
    {
        return 'name';
    }

    protected function validateLogin(Request $request)
    {
        
        $this->validate($request, [ 'name' => 'required|exists:users,' . 'name' . ',estado,A', 'password' => 'required', ]);
    }



}
