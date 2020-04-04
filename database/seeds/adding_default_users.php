<?php

use Illuminate\Database\Seeder;

class adding_default_users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		
		  DB::table('users')->insert([

            'name' => 'admin',

            'username' => 'admin',

            'email' => 'admin@gmail.com',

            'password' => bcrypt('demouser'),

            

        ]);
		
		DB::table('users')->insert([

            'name' => 'user1',

            'username' => 'user1',

            'email' => 'user1@gmail.com',

            'password' => bcrypt('demouser'),

            

        ]);
    }
	
}
