<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

   

// overriding the username function to accept both username and login
public function username()
{


    $login_with = DB::select('SELECT * FROM adminconfig');
   
    $login = request()->input('identity');


  
    if($login_with[0]->login_with== 'email'){

            $field = 'email';

    }else if($login_with[0]->login_with == 'username'){

        $field = 'username';

    }else{

       
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email': 'username';


    }


    request()->merge([$field => $login]);

   
    return $field;
}

    public function validateLogin(Request $request)
    {
        
       
        $messages = [
            'identity.required' => 'Email or username cannot be empty',
            'email.exists' => 'Email or username already registered',
            'username.exists' => 'Username is already registered',
            'password.required' => 'Password cannot be empty',
        ];

        $request->validate([
            'identity' => 'required|string',
            'password' => 'required|string',
            'email' => 'string|exists:users',
            'username' => 'string|exists:users',
        ], $messages);


    }

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function authenticated(Request $request, $user){

        $pwd_reseted = $user->reset_pwd_on_flogin;

         return ($pwd_reseted === 0
        )? redirect('update-password'): redirect()->intended($this->redirectPath()) ;

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

    
}
