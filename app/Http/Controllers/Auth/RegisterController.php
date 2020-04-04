<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\WelcomeMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
	public $oneTimePassword; 
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
       // $this->middleware('guest');
    }



    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $roles_array =array();

        $roles = DB::select('SELECT * FROM roles');

     

       foreach($roles as $role){
            array_push($roles_array, $role->role);
       }

        
      
        return view('auth.register', ['roles'=>$roles_array]);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                    
            'name' => ['required', 'string', 'max:255'],
            'username' =>['required', 'string', 'max:25', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'roles' => ['required', 'string',  'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
	$oneTimePassword = Str::random(8);
		
		
	$mail_configure = env("MAIL_USERNAME");
	$from_mail_configured = env("MAIL_FROM_ADDRESS");
		
		if($mail_configure==NULL || $from_mail_configured ==NULL){
					
					return 'error';
					
		}

		$user= User::create([
            
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($oneTimePassword),
            'reset_pwd_on_flogin' => 0,
			
        ]);
        
        if($user){
            $roles = explode(',',$data['roles']);
            foreach ($roles as $role){
                $role_id = DB::select("SELECT id FROM roles WHERE role = '".$role."'");
                DB::table('user_role_mappings')->insert(['user_id'=> $user->id, 'role_id' => $role_id[0]->id]);
            }
        }
		
        Mail::to($data['email'])->send(new WelcomeMail($user,$oneTimePassword));

        return $user;
    }
	
		public function register(Request $request)
	{
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
       
        if($user != 'error'){
            event(new Registered($user));

        return $this->registered($request, $user)
                        ?: redirect($this->redirectTo)->with('success', 'User Registered successfully...!');
        }
        else{
            return back()->with("error","Configure mail to send an email to registred user");
        }
		
    }
}
