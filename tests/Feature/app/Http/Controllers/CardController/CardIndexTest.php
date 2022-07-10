<?php

namespace Tests\Feature\app\Http\Controllers\CardController;

use App\Card;
use App\Stage;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
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
        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonCount($cardsCount);
    }

    public function test_it_shows_cards_grouped_by_stages()
    {
        $this->withoutExceptionHandling();
        $anotherUser = factory(User::class)->create();
        factory(Card::class,10)->create([
            'user_id' => $anotherUser->id,
            'stage_id' => Stage::BUFFER
        ]);

        factory(Card::class,2)->create([
            'stage_id' => Stage::BUFFER
        ]);

        $response = $this->getJson('/api/get-cards-by-stage');
        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonCount(3);

        $cantidadCards = collect(json_decode($response->getContent()))->where('id', Stage::BUFFER)->first()->cards_of_current_user;
        $this->assertEquals(2, count($cantidadCards));
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
        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonCount($cardsCountOfCurrentUser);
    }
}
