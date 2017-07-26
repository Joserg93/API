<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creamos una instancia de Faker
		$faker = Faker::create();

		// Creamos un bucle para cubrir 5 fabricantes:
		for ($i=0; $i<4; $i++)
		{
			// Cuando llamamos al método create del Modelo User 
			// se está creando una nueva fila en la tabla.
			User::create(
				[
					'name'=>$faker->name(),
					'email'=>$faker->email(),
					'password'=>Hash::make('123456')	// de 6 dígitos como máximo.
				]
			);
		}
    }
}
