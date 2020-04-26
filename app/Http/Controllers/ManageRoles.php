<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Log;
class ManageRoles extends Controller
{


    public function index(){

      /* List of roles and  permissions */
       $total_roles =   DB::table('roles')->orderBy('id')->pluck('role')->toArray();

       $permissions = DB::select(' SELECT * FROM permissions');
  
       
      /* array of role-permission mapping  */ 
       $roles_permissions = DB::table('role_permission_mappings')
            ->join('roles', 'role_permission_mappings.role_id', '=', 'roles.id')
            ->join('permissions', 'role_permission_mappings.permission_id', '=', 'permissions.id')
            ->select('roles.role',  'permissions.permission')
            ->get();

        /* $roles is an array contain the List of all roles with the permmisions of it. */
           $roles = array();

          /* Assign all the roles  */ 
           foreach($total_roles as $role){
            $roles[$role] = ' ';
          }

          /* permissions of roles are added to the $roles array */
            if(sizeof($roles_permissions)>0){
              foreach($roles_permissions as $role){
                $role_permission = json_decode(json_encode($role),true);

                  if(isset($roles[$role_permission['role']]) && $roles[$role_permission['role']] !== ' ' ){
                    $roles[$role_permission['role']] = $role_permission['permission'].',' .$roles[$role_permission['role']];
                   
                  }
                  else{
                     $roles[$role_permission['role']] =  $role_permission['permission'];
                   
                  }
                }                
            }

        return view('usermanagement.manageroles',['roles' => $roles, 'permissions'=> $permissions]);
      

    }


    public function saveRoles(Request $request) {

      $rolesData = json_decode($request->getContent(), true);

 
   
      foreach($rolesData as $role){

        $roel_id = 0;
       

       $roleDetails = array("role" => trim($role['role'])); 
 
        if($role["previous_role"]!=NULL && $role["previous_role"]!= 'on'){

    
          $roel_id = DB::table('roles')->select('id')->where('role',$role['previous_role'])->get();
         
     
        }
        
        if(!empty($roel_id) && count($roel_id)>0){
        
          $role_id = $roel_id[0]->id;
           $updated_role = DB::table('roles')->where('id',$role_id)->update($roleDetails);
           log::alert("update ".$updated_role);
           

        }
        else{
         
          $role_id = DB::table('roles')->insertGetId(['role' => $role['role'],'description' => "new roles"]);
        }

        if($role_id && isset($role["permissions"]) && $role["permissions"] !== ''){

          $permissions = explode(',',$role["permissions"]);

         

          if(sizeof($permissions)>0){

            log::info("checking for permission");
            DB::table('role_permission_mappings')->where('role_id', $role_id )->delete();
          
            foreach($permissions as $permission){
              $permission_id = DB::table('permissions')->select('id')->where('permission',$permission)->get();
  
              DB::table('role_permission_mappings')->insert(['role_id' => $role_id, 'permission_id' => $permission_id[0]->id]);
            }
          }
         

        }

        

      
      }

      return response()->json([
        'error' => false
    ], 200);
      
    }


    function deleteRoles(Request $request ){

      $rolesData = json_decode($request->getContent(), true);
   
      foreach($rolesData as $role){
      DB::table('roles')->where('role', $role['role'])->delete();
      }

    }

}