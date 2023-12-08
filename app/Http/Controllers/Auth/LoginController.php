<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
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
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo() {
        $role = auth()->user()->getrole->name; 
        // dd($role);
        switch ($role) {
          case 'Super Admin':
            return '/super-admin';
            break;
          case 'PM':
            return '/website';
            break; 
          case 'Team Lead':
            return '/website_list';
            break;
          case 'Scrapper':
            return '/website_list';
            break;
          case 'PA':
            return '/website_list';
            break;
          case 'QC':
            return '/website_list';
            break;
          case 'QA':
            return '/website_list';
            break;
          case 'Client':
            return '/website_list';
            break;
          default:
            return '/login'; 
          break;
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function customLogin()
    {
        return view('auth.login');
    }    

    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
