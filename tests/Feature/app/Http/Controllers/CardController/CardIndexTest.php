<?php

namespace Tests\Feature\app\Http\Controllers\CardController;

use App\Card;
use App\Stage;
use App\User;
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

    public function test_only_show_cards_of_user_logged_in()
    {
        $this->withoutExceptionHandling();

        $anotherUser = factory(User::class)->create();
        $cardsCountOfCurrentUser = 5;

        factory(Card::class,$cardsCountOfCurrentUser)->create([
            'user_id' => auth()->id()
        ]);

        factory(Card::class,10)->create([
            'user_id' => $anotherUser->id
        ]);

        $response = $this->getJson('/api/cards');
        $response->assertStatus(200)
                ->assertJsonCount($cardsCountOfCurrentUser);
    }
}
