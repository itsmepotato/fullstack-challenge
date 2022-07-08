<?php

namespace Tests\Feature;

use App\Card;
use App\Stage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CardTest extends TestCase
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

    public function test_it_can_update_a_card()
    {
        $this->withoutExceptionHandling();

        $card = factory(Card::class)->create([
            'name' => 'Sacar a los perros afuera',
            'delivery_date' => '2022-07-05'
        ]);

        $fields = [
            'name' => 'Hacer tarea',
            'stage_id' => Stage::BUFFER,
            'delivery_date' => '2022-07-05'
        ];

        $response = $this->putJson('/api/cards/'. $card->id, $fields);

        $response->assertStatus(201)
                 ->assertJson([
                        'name' => $fields['name'],
                 ]);

        $this->assertDatabaseHas('cards', [
            'name' => $fields['name'],
        ]);

        $this->assertDatabaseMissing('cards', [
            'name' => $card->name,
        ]);
    }

    public function test_it_can_delete_a_card()
    {
        $this->withoutExceptionHandling();

        $card = factory(Card::class)->create();

        $response = $this->deleteJson('/api/cards/'. $card->id);
        $response->assertStatus(204);

        $this->assertDatabaseMissing('cards',[
            'id' => $card->id
        ]);
    }

}
