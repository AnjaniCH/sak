<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
        	'nama'=>'Admin',
        	'email'=>'admin@sak.dev',
        	'password'=>bcrypt('12345')
        ]);
    }
}
