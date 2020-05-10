<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Frontend\Auth\LoginRequest;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }
    public function login(LoginRequest $request)
    {   
        $input = $request->all();
        $data = array('email' => $input['email'], 'password' => $input['password']);
        $remember = $request->filled('remember');
        if(auth()->attempt($data,$remember)){
            toastr()->success('Chúc mừng '.Auth::user()->name.' đăng nhập thành công', trans('labels.backend.common.noti'));
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('login')
                    ->withErrors(['Tài khoản hoặc mật khẩu không chính xác']);
        }
    }
    public function logout(Request $request){
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
