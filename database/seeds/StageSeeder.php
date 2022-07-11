<?php

use App\Stage;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Stage::firstOrCreate(
            [
                'id' => 'BUFFER'
            ],
            [
                'name' => 'Buffer',
                'order' => 1,
                'description' => null,
            ]);

        Stage::firstOrCreate(
            [
                'id' => 'WORKING'
            ],
            [
                'name' => 'Working',
                'order' => 2,
                'description' => null,
            ]);

        Stage::firstOrCreate(
            [
                'id' => 'DONE'
            ],
            [
                'name' => 'Done',
                'order' => 3,
                'description' => null,
            ]);



    }
}
