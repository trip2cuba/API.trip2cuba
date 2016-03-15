<?php

use Illuminate\Database\Seeder;
use ApiTripCuba\Entities\User;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder 
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//User::create
		$faker = Faker::create();

		
		for($i = 0; $i < 50; $i++)
		{
			User::create
			([
				'first_name' => $faker->firstName(),
				'last_name' => $faker->lastName(),
				'email' => $faker->email(),
				'password' => bcrypt('123456'),
				//'age' => $faker->numberBetween(1,$cantidad)
			]);
		}
	}
}
