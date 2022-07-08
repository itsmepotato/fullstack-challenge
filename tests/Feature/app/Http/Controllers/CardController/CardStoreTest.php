<?php

namespace Tests\Feature\app\Http\Controllers\CardController;

use App\Card;
use App\Stage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CardStoreTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->loginAsARandomUser();
        $this->seed('StageSeeder');
    }

    public function test_it_can_store_a_card()
    {
        $this->withoutExceptionHandling();

        $fields = [
            'name' => 'google',
            'stage_id' => Stage::BUFFER,
            'delivery_date' => '2022-07-05'
        ];

        $response = $this->postJson('/api/cards', $fields);

        $response->assertStatus(201)
                 ->assertJson([
                     'name' => $fields['name'],
                 ]);

        $this->assertDatabaseHas('cards', [
            'name' => $fields['name'],
        ]);
    }

}
