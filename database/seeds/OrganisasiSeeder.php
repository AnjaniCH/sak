<?php

use Illuminate\Database\Seeder;

class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('organisasi')->insert([
        	[
        		'nama'=>'Produksi',
        		'parent_id'=>null
        	],
        	[
        		'nama'=>'Ketertiban',
        		'parent_id'=>null
        	],
        	[
        		'nama'=>'IT',
        		'parent_id'=>null
        	]
        ]);
    }
}
