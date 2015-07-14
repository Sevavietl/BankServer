<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
			'first_name' => 'John',
			'last_name' => 'Dow'
		]);

        User::create([
			'first_name' => 'Jane',
			'last_name' => 'Dow'
		]);

        User::create([
			'first_name' => 'Jack',
			'last_name' => 'Doe'
		]);
    }
}
