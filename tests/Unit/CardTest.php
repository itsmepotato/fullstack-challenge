<?php

namespace Tests\Unit;

use App\User;
use App\Card;
use App\Stage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CardTest extends TestCase
{
    use RefreshDatabase;

    public function test_card_belongs_to_user()
    {
        $card = factory(Card::class)->create();

        $this->assertInstanceOf(User::class, $card->user);
    }

    public function test_card_belongs_to_stage()
    {
        $card = factory(Card::class)->create();

        $this->assertInstanceOf(Stage::class, $card->stage);
    }
}
