<?php

namespace Tests\Unit;

use App\Card;
use App\Stage;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StageTest extends TestCase
{
    use RefreshDatabase;

    public function test_stage_has_many_cards()
    {
        $stage = factory(Stage::class)->create();

        $this->assertInstanceOf(Collection::class, $stage->cards);
    }

    public function test_stage_has_many_cards_by_user()
    {
        $this->loginAsARandomUser();
        $user = User::first();
        $stage = factory(Stage::class)->create();
        factory(Card::class, 2)->create([
            'user_id' => $user->id,
            'stage_id' => $stage->id
        ]);


        $anotherUser = factory(User::class)->create();
        factory(Card::class, 5)->create([
            'user_id' => $anotherUser->id,
            'stage_id' => $stage->id
        ]);


        $this->assertEquals(2, $stage->cardsOfCurrentUser->count());
    }
}
