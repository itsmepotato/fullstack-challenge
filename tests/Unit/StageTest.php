<?php

namespace Tests\Unit;

use App\Stage;
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
}
