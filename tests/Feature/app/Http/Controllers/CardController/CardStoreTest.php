<?php

namespace Tests\Feature\app\Http\Controllers\CardController;

use App\Card;
use App\Stage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
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

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson([
                     'name' => $fields['name'],
                 ]);

        $this->assertDatabaseHas('cards', [
            'name' => $fields['name'],
        ]);
    }

    public function test_name_is_required_when_a_card_is_stored()
    {
        $fields = [
            // 'name' => 'google',
            'stage_id' => Stage::BUFFER,
            'delivery_date' => '2022-07-05'
        ];

        $response = $this->postJson('/api/cards', $fields);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['name']);
    }

    public function test_delivery_date_is_required()
    {
        $fields = [
            'name' => 'google',
            'stage_id' => Stage::BUFFER,
            // 'delivery_date' => '2022-07-05'
        ];

        $response = $this->postJson('/api/cards', $fields);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['delivery_date']);
    }

    public function test_delivery_date_must_be_a_date()
    {
        $fields = [
            'name' => 'google',
            'stage_id' => Stage::BUFFER,
            'delivery_date' => '2022-07-05sss'
        ];

        $response = $this->postJson('/api/cards', $fields);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['delivery_date']);
    }

    public function test_stage_id_is_required()
    {
        $fields = [
            'name' => 'google',
            // 'stage_id' => Stage::BUFFER,
            'delivery_date' => '2022-07-05'
        ];

        $response = $this->postJson('/api/cards', $fields);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['stage_id']);
    }

    public function test_stage_must_exists()
    {
        $fields = [
            'name' => 'google',
            'stage_id' => 'RANDOM-STAGE',
            'delivery_date' => '2022-07-05'
        ];

        $response = $this->postJson('/api/cards', $fields);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['stage_id']);
    }

    public function test_the_card_has_to_be_unique_on_store()
    {
        $cardName = 'tarea random';

        factory(Card::class)->create([
            'name' => $cardName
        ]);

        $fields = [
            'name' => $cardName,
            'stage_id' => Stage::BUFFER,
            'delivery_date' => '2022-07-05'
        ];

        $response = $this->postJson('/api/cards', $fields);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['name']);
    }
}
