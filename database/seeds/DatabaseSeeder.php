<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker::create();
    	// Main from address
    	DB::insert('INSERT INTO addresses (name, address) VALUES (?, ?)', ['John Testel', 'jtest@test.com']);

    	// Main app
        DB::insert('INSERT INTO apps (name, description, from_address_id) VALUES (?, ?, ?)', ['testapp', 'A test application', 1]);

        for ($i=2; $i < 6; $i++) { 
        	DB::insert('INSERT INTO addresses (name, address) VALUES (?, ?)', [$faker->name, $faker->email]);
        	DB::insert('INSERT INTO app_addresses (app_id, address_id) VALUES (?, ?)', [1, $i]);
        }

        DB::insert('INSERT INTO addresses (name, address) VALUES (?, ?)', ['Suzy Testel', 'stest@test.com']);
        DB::insert('INSERT INTO app_addresses (app_id, address_id) VALUES (?, ?)', [1, 6]);
    }
}
