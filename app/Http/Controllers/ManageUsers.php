<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;


class ManageUsers extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //
public function index(){

    $users =   DB::select('SELECT * FROM users');

    return view('usermanagement.manageusers')->with('users',$users);

}

public function edit($id)
{
    
    $user = DB::select('SELECT * FROM users WHERE id ='.$id);
    
    
    return view('usermanagement.viewUserDetails')->with('res_user',$user[0]);
    
    
}

public function editUser(Request $request ){
    

   
    $request->validate([

        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        'roles' => ['required', 'string',  'max:255'],

    ]);

        $userDetails = array("name" => $_POST["name"],
        "email" => $_POST["email"],
        "roles" => $_POST["roles"]);
        
     

        DB::table('users')->where('id',$_POST['id'])->update($userDetails);

        return redirect('/manageusers')->with('success', 'SUccessfully updated User Details.');


}




						
						

public function destroy($id){

    DB::table('users')->where('id', '=', $id)->delete();
    return redirect('/manageusers')->with('success', 'User Deleted');
}


}