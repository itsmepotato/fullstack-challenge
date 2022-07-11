<?php

namespace Tests\Feature\app\Http\Controllers\CardController;

use App\Card;
use App\Stage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CardDestroyTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->loginAsARandomUser();
        $this->seed('StageSeeder');
    }

    public function test_it_can_delete_a_card()
    {
        $this->withoutExceptionHandling();

        $card = factory(Card::class)->create();

        $response = $this->deleteJson('/api/cards/'. $card->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('cards',[
            'id' => $card->id
        ]);
    }

}
