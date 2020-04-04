<?php

namespace App\Http\Controllers;
use App\user;
use Illuminate\Http\Request;
use App\Http\Controllers\controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



class CusResetpasswordController extends Controller
{
 

    public function index(){

        return view('auth.passwords.cusresetpassword');
  
    }


    public function cuspasswordrest(Request $request)
    {
        
        $this->validate($request, [

            'oldpassword' => 'required',
            'password' => 'required|confirmed'
        ]);


        $hasedpaswword = Auth::user()->password;


        if(\Hash::check($request->oldpassword, $hasedpaswword )){

            $user = User::find(Auth::id());

            $user->password = Hash::make($request->password);
            $user->save();
            
            $redirect = Auth::user()->reset_pwd_on_flogin;

            if($redirect === 0){
                DB::table('users')->where('id', Auth::id())->update(['reset_pwd_on_flogin' => 1]);
            }
            
            Auth::logout();
            return redirect()->route('login')->with("SuccessMsg","Password changes successfully");

        }
        else {
            
            //Keep error message for wrong password

            return back()->with("error","In-valid Old Password");

        }

        


    }


}
