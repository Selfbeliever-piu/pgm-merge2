<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
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
    $users_list =   DB::select("SELECT * FROM users");
    $users_list = json_decode(json_encode($users_list),true);

    $users_roles = DB::table('user_role_mappings')
            ->join('users', 'user_role_mappings.user_id', '=', 'users.id')
            ->join('roles', 'user_role_mappings.role_id', '=', 'roles.id')
            ->select('users.username',  'roles.role')
            ->get();



    $users = array();

    foreach ($users_list as $user){

        $users[$user['username']] = ' ';
        
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


     return view('usermanagement.manageusers')->with(['users_roles'=> $users, "users" => $users_list]);

}

public function edit(Request $request)   
{


    // log::alert($request->input('userName'));

    $username = $request->input('userName');
    
    if(isset($username) && $username!== ' '){
    
    $user = DB::select("SELECT * FROM users WHERE username ='".$username."'");
    $user = $user[0];

    $user_roles = $request->input('userRoles');

    } 
    else{
        $user='';
        $user_roles = $request->old('roles');
        }
    $allRoles = DB::table('roles')->pluck('role')->toArray();


    return view('usermanagement.viewUserDetails')->with(['res_user'=>$user, 'allRoles'=> $allRoles, 'selectedRoles'=>$user_roles]);
    
    
    
}



public function editUser(Request $request ){



        $request->validate([

            'name' => ['required','unique:users,name,'.$request->input('id').',id', 'string', 'max:255'],
            'email' => ['required', 'unique:users,email,'.$request->input('id').',id','string', 'email', 'max:255'],
            'roles' => ['required'],
            

        ],[
            'name.required' => 'username is required',
            'roles.required' => 'Please select atleast one role.'
        ]
    );

    

        $roles = explode(',',$_POST['roles']);
   

        $userDetails = array("username" => $_POST["name"],
        "email" => $_POST["email"]);
        
     

        DB::table('users')->where('id',$_POST['id'])->update($userDetails);


        DB::table('user_role_mappings')->where('user_id', $_POST['id'] )->delete();
        foreach($roles as $role){

            $role_id = DB::table('roles')->select('id')->where('role',$role)->get();
        
            DB::table('user_role_mappings')->insert(['user_id' => $_POST['id'], 'role_id' => $role_id[0]->id]);
           
         }

        return redirect('/manageusers')->with('success', 'Successfully updated User Details.');


}
						

public function destroy($id){

    log::alert($id);

    DB::table('users')->where('username', '=', $id)->delete();
    return redirect('/manageusers')->with('success', 'User Deleted');
}


}