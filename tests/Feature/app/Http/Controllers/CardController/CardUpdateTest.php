<?php

namespace Tests\Feature\app\Http\Controllers\CardController;

use App\Card;
use App\Stage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CardUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->loginAsARandomUser();
        $this->seed('StageSeeder');
    }

    public function test_it_can_update_a_card()
    {
        $this->withoutExceptionHandling();

        $card = factory(Card::class)->create([
            'name' => 'Sacar a los perros afuera',
            'stage_id' => Stage::BUFFER,
            'delivery_date' => '2022-07-05'
        ]);

        $fields = [
            'name' => 'Sacar a los perros afuera',
            'stage_id' => Stage::WORKING,
            'delivery_date' => '2022-08-05'
        ];

        $response = $this->putJson('/api/cards/'. $card->id, $fields);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJson([
                        'stage_id' => $fields['stage_id'],
                        'delivery_date' => $fields['delivery_date'],
                 ]);

        $this->assertDatabaseHas('cards', [
            'stage_id' => $fields['stage_id'],
            'delivery_date' => $fields['delivery_date'],
        ]);

        $this->assertDatabaseMissing('cards', [
            'stage_id' => $card->stage_id,
        ]);
    }

    private function getCard(): Card
    {
        return factory(Card::class)->create([
            'name' => 'Tarea random',
            'stage_id' => Stage::BUFFER,
            'delivery_date' => '2022-07-05'
        ]);
    }

    public function test_name_is_required_when_a_card_is_updated()
    {
        $card = $this->getCard();
        $fields = [
            // 'name' => 'google',
            'stage_id' => Stage::BUFFER,
            'delivery_date' => '2022-07-05'
        ];

        $response = $this->putJson('/api/cards/'. $card->id, $fields);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_delivery_date_is_required_on_update()
    {
        $card = $this->getCard();
        $fields = [
            'name' => 'google',
            'stage_id' => Stage::BUFFER,
            // 'delivery_date' => '2022-07-05'
        ];

        $response = $this->putJson('/api/cards/'. $card->id, $fields);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['delivery_date']);
    }

    public function test_delivery_date_must_be_a_date_on_update()
    {
        $card = $this->getCard();
        $fields = [
            'name' => 'google',
            'stage_id' => Stage::BUFFER,
            'delivery_date' => '2022-07-05sss'
        ];

        $response = $this->putJson('/api/cards/'. $card->id, $fields);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['delivery_date']);
    }

    public function test_stage_id_is_required_on_update()
    {
        $card = $this->getCard();
        $fields = [
            'name' => 'google',
            // 'stage_id' => Stage::BUFFER,
            'delivery_date' => '2022-07-05'
        ];

        $response = $this->putJson('/api/cards/'. $card->id, $fields);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['stage_id']);
    }

    public function test_stage_must_exists_on_update()
    {
        $card = $this->getCard();
        $fields = [
            'name' => 'google',
            'stage_id' => 'RANDOM-STAGE',
            'delivery_date' => '2022-07-05'
        ];

        $response = $this->putJson('/api/cards/'. $card->id, $fields);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->assertJsonValidationErrors(['stage_id']);
    }

    public function test_the_card_has_to_be_unique_on_update()
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
