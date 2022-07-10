<?php

use App\Card;
use App\Stage;
use App\User;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'kanban@test.com')->first();

        Card::firstOrCreate(
            [
                'name' => 'Agregar subtareas al kanban'
            ],
            [
                'user_id' => $user->id,
                'stage_id' => Stage::BUFFER,
                'delivery_date' => now()->addDay(10)->toDateString(),
            ]
        );

        Card::firstOrCreate(
            [
                'name' => 'Testing Kanban'
            ],
            [
                'user_id' => $user->id,
                'stage_id' => Stage::WORKING,
                'delivery_date' => now()->addDay(2)->toDateString(),
            ]
        );
    }
}
