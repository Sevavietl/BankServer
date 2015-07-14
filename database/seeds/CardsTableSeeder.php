<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Card;

class CardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Card::create([
			'card_number' => '1234 1234 1234 1234',
			'card_expiration' => '07/16',
			'balance' => 100,
			'user_id' => 1,
		]);

        Card::create([
			'card_number' => '1235 1235 1235 1235',
			'card_expiration' => '07/16',
			'balance' => 90,
			'user_id' => 2,
		]);

        Card::create([
			'card_number' => '1236 1236 1236 1236',
			'card_expiration' => '07/16',
			'balance' => 120,
			'user_id' => 3,
		]);
    }
}
