<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            [
                'email' => 'kanban@test.com'
            ],
            [
                'name' => 'Kanban',
                'email' => 'kanban@test.com',
                'password'=> Hash::make('kanban123'),
            ]);
    }
}
