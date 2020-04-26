<?php

use Illuminate\Database\Seeder;

class rolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('roles')->insert([

            'role' => 'superadmin',

            'description' => 'Having all access '
        ]);

        DB::table('roles')->insert([
        
            'role' => 'admin',
            
            'description' => 'who had all access',
            
            ]);


        DB::table('roles')->insert([
        
                'role' => 'manager',
                
                'description' => 'who manages',
                
        ]);

        DB::table('roles')->insert([
        
            'role' => 'developer',
           
            'description' => 'who develops',
            
        ]);
    }
}
