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
                'description' => null,
            ]);

        Stage::firstOrCreate(
            [
                'id' => 'WORKING'
            ],
            [
                'name' => 'Working',
                'description' => null,
            ]);

        Stage::firstOrCreate(
            [
                'id' => 'DONE'
            ],
            [
                'name' => 'Done',
                'description' => null,
            ]);



    }
}
