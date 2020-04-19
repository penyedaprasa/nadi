<?php

namespace App\Http\Controllers\AuthAdmin;

use App\Http\Controllers\Controller;
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



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }


    /**
    */
    public function showLoginForm()
    {
        return view('authAdmin.Login');
    }


    /**
    */
    public function Login(Request $request)
    { 
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credential = [
            'email' => $request->email,
            'password' => $request->password,
            'level' => '1'
        ];

        //Attempt to log the user in
        if (Auth::guard('admin')->attempt($credential, $request->member)){
            //jika login sukses, kemudian dialihkan ke halaman
            return redirect()->intended(route('admin.home'))->with('alert', 'Berhasil Login');
        }

        //jika tidak sukses, kembali mengisi di form login
        return redirect()->back()->withInput($request->only('email', 'remember'))->with('alert', 'Akun Belum Terdaftar');
    }


}
