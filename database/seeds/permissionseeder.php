<?php

use Illuminate\Database\Seeder;

class permissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('permissions')->insert([
        
        'permission' => 'create_client',
        'description' => 'one who can create a new client',
        
        ]);

        DB::table('permissions')->insert([
        
            'permission' => 'create_project',
            'description' => 'one who can create a new project',
            
        ]);


        DB::table('permissions')->insert([
        
                'permission' => 'create_task',
                'description' => 'one who can create a new task',
                
         ]);


         DB::table('permissions')->insert([
        
            'permission' => 'create_contacts',
            'description' => 'one who can create a new contacts',
            
        ]);
    }
}
