<?php

use Illuminate\Database\Seeder;
use App\Archive;
use App\User;
// Le indicamos que utilice también Faker.
// Información sobre Faker: https://github.com/fzaninotto/Faker
use Faker\Factory as Faker;
class ArchivesSeeder extends Seeder
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

		// Para cubrir los aviones tenemos que tener en cuanta qué fabricantes tenemos.
		// Para que la clave foránea no nos de problemas.
		// Averiguamos cuantos fabricantes hay en la tabla.
		$cuantos= User::all()->count();

		// Creamos un bucle para cubrir 20 aviones:
		for ($i=0; $i<9; $i++)
		{
			// Cuando llamamos al método create del Modelo Avion 
			// se está creando una nueva fila en la tabla.
			Archive::create(
				[
				 'name'=>$faker->word(),
				 'date'=>$faker->dateTime($max = 'now'),
				 'text'=>$this->encrypt_string($faker->text($maxNbChars = 30)),	
				 'user_id'=>$faker->numberBetween(1,$cuantos)
				]
			);
		}
    }
    function encrypt_string($input)
    {    
        $search = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',' ','1','2','3','4','5','6','7','8','9','0',',','.');
        $replace = array('☺','☻','♥','♦','♣','♠','•','◘','◙','♂','♀','♪','♫','☼','►','◄','↕','¶','§','▬','↨','↑','↓','→','←','∟','↔','▲','▼','ß','Ô','µ','þ','Þ','Û','±','¾','¹','³');  
        $input = str_ireplace($search,$replace,$input);
        return $input;
    }
}
