<?php

use Illuminate\Database\Seeder;

class admin_config_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
		  DB::table('adminconfig')->insert([
        
            'login_with' => 'both',
            
            
            ]);

		
    }
}
