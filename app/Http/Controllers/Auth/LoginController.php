<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

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
  protected $redirectTo = '/home';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  public function login(Request $request) {
    $credentials = [
      'email' => $request->input('email'),
      'password' => $request->input('password')
    ];

    if (!Auth::attempt($credentials)) {
      return response()->json([
        'status' => 'failed', 'error' => 'Login failed.'
      ], 400); 
    }

    $user = User::where('email', $credentials['email'])->first();

    return response()->json([
      'status' => 'success', 'user' => $user
    ], 200); 
  }
}
