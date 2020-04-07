<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use DB;
use Illuminate\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
       
              $gate->define('1',function($user){

                
                    return $this->check_permission('1', $user);
            

            });

            

      




    }

   

    public function check_permission($permission, $user){

        

        if (\Schema::hasTable('roles') && \Schema::hasTable('permissions') ) {
            
        
            $user_roles = explode (",", $user->roles);

             $user_roles = DB::select("SELECT role_id FROM user_role_mappings WHERE user_id = '".$user->id."'");

            
                    $temp1 = json_encode($user_roles);
                    $user_roles = json_decode($temp1,1);
           
                    foreach($user_roles as $key=>$value){

                     $u_roles[] =  $value['role_id'];
                    }

         

       
           
        $eachrole = DB::select("SELECT role_id FROM role_permission_mappings WHERE permission_id = ".$permission);
                  
          
         $rarray= array();
         foreach($eachrole as $key=>$value){

            $rarray[] = $value->role_id;
        }

           
             if(!empty(array_intersect($u_roles, $rarray))){

                return true;

             }else{

                
                 
               return false;

             }
                
           
        
        }
   
   
    }



}
