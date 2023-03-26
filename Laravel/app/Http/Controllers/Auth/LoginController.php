<?php

namespace App\Http\Controllers\Auth;

use App\ExcludeTrafficIP;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function index(Request $request)
    {
        return view('Auth.Login.index');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (Auth::attempt($credentials)) {

                $exludeIP = new ExcludeTrafficIP();

                $exludeIP->IP = geoip()->getClientIP();
                $exludeIP->Title = Auth::user()->name . " Loged In ";
                $exludeIP->CreateDate = new DateTime();
                $exludeIP->save();

                // Authentication passed...
                return redirect()->intended($redirectTo);
            }
        } catch (\Exception $e) {
            return  \Redirect::back()->withErrors(['Error:' . $e->getMessage()])->withInput($request->input())->withInput();
        }

        return redirect()->route('user.login')
            ->with('fail', 'Login Failed');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}
