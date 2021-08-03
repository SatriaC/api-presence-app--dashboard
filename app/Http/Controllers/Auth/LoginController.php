<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function login (Request $request)
    {
        // Validator::make($request->all(), [
        //     "email" => 'required|email',
        //     "password" => "required|string|min:6"
        // ])->validate();
        $this->validate($request,[
            "email" => 'required|email',
            "password" => "required|string|min:6"
        ]);

        $login = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // $db = DB::connection('mysql2');

        $user = User::where('email', $request->email)->first();
        // dd($user->email);
        if ($user) {
            if($user->flag == 1 ){
                if(Auth::attempt($login)){
                    return redirect()->route('dashboard')->with(['success' => 'Berhasil Login']);
                }
                return redirect('/login')->with(['error' => 'Password tidak sesuai']);
            }
            return redirect('/login')->with(['error' => 'Mohon maaf, anda tidak memiliki hak login']);
        }
        return redirect('/login')->with(['error' => 'Email tidak terdaftar']);
    }
}
