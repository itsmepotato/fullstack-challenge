<?php

namespace Tests\Feature\app\Http\Controllers\CardController;

use App\Card;
use App\Stage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CardIndexTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->loginAsARandomUser();
        $this->seed('StageSeeder');
    }

    public function test_it_shows_a_list_of_cards()
    {
        $this->withoutExceptionHandling();

        factory(Card::class,2)->create();

        $cardsCount = Card::count();

        $response = $this->getJson('/api/cards');
        $response->assertStatus(200)
                ->assertJsonCount($cardsCount);
    }
}
