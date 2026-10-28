<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    // GANTI variable $redirectTo = ... dengan fungsi ini:
    public function redirectTo()
    {
        if (auth()->user()->role == 'admin') {
            return route('admin.requests'); // Admin ke Dashboard
        }
        return route('welcome'); // User ke Halaman Depan
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        // Cek Role User
        if ($user->role == 'admin') {
            // Kalau Admin, lempar ke Dashboard Admin
            return redirect()->route('admin.requests');
        }

        // Kalau User Biasa, lempar ke Halaman Depan (Welcome/Home)
        // Kamu bisa ganti route('welcome') kalau mau ke halaman utama yg ada carouselnya
        // Atau route('home') kalau mau ke dashboard user biasa
        return redirect()->route('welcome'); 
    }
}
