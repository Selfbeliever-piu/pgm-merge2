<?php

namespace App\Http\Controllers\Adminconfig;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminconfigController extends Controller
{
    //
    public function __construct()
    {

        //$this->middleware('guest')->except('logout');
    }


public function userloginwith(){


    $login_with = DB::select('SELECT * FROM adminconfig');
    //$login_with = $login_with[0]->login_with;
    return view('usermanagement.loginwith',['loginwith'=>$login_with]);
}


public function saveuserloginwith(){

    DB::table('adminconfig')->update(['login_with' => $_POST['userloginwith']]);

    $login_with = DB::select('SELECT * FROM adminconfig');

    return view('usermanagement.loginwith',['loginwith'=>$login_with]);

}


}
