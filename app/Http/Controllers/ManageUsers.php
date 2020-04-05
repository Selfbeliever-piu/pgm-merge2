<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
    $users_list =   DB::table('users')->pluck('username')->toArray();


    $users_roles = DB::table('user_role_mappings')
            ->join('users', 'user_role_mappings.user_id', '=', 'users.id')
            ->join('roles', 'user_role_mappings.role_id', '=', 'roles.id')
            ->select('users.username',  'roles.role')
            ->get();



    $users = array();

    foreach ($users_list as $user){

        //log::alert($user);
        $users[$user] = ' ';
        
    }


    if(sizeof($users_roles)>0){
        foreach($users_roles as $role){
          $user_roles = json_decode(json_encode($role),true);

            if(isset($users[$user_roles['username']]) && $users[$user_roles['username']] !== ' ' ){
              $users[$user_roles['username']] = $user_roles['role'].',' .$users[$user_roles['username']];
             
            }
            else{
               $users[$user_roles['username']] =  $user_roles['role'];
             
            }
          }                
      }

    return view('usermanagement.manageusers')->with('users',$users);

}

public function edit(Request $request)   
{
    
    $user = DB::select("SELECT * FROM users WHERE username ='".$_POST['userName']."'");
    $allRoles = DB::table('roles')->pluck('role')->toArray();


    return view('usermanagement.viewUserDetails')->with(['res_user'=>$user[0], 'allRoles'=> $allRoles, 'selectedRoles'=>$_POST['userRoles']]);
    
    
}

public function editUser(Request $request ){

   
    $request->validate([

        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        

    ]);

        $roles = explode(',',$_POST['roles']);
   

        $userDetails = array("username" => $_POST["name"],
        "email" => $_POST["email"]);
        
     

        DB::table('users')->where('id',$_POST['id'])->update($userDetails);


        DB::table('user_role_mappings')->where('user_id', $_POST['id'] )->delete();
        foreach($roles as $role){

            $role_id = DB::table('roles')->select('id')->where('role',$role)->get();
        
            DB::table('user_role_mappings')->insert(['user_id' => $_POST['id'], 'role_id' => $role_id[0]->id]);
           
         }

        return redirect('/manageusers')->with('success', 'SUccessfully updated User Details.');


}
						

public function destroy($id){

    log::alert($id);

    DB::table('users')->where('username', '=', $id)->delete();
    return redirect('/manageusers')->with('success', 'User Deleted');
}


}