<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(

            [

            
            rolesSeeder::class,
            permissionseeder::class,
            adding_default_users::class,
            admin_config_seeder::class,


            ]

        );
        
    }
}
