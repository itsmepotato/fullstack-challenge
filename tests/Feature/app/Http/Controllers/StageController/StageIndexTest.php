<?php

namespace Tests\Feature\app\Http\Controllers\StageController;

use App\Card;
use App\Stage;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class StageIndexTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->loginAsARandomUser();
        $this->seed('StageSeeder');
    }

    public function test_it_shows_a_list_of_stages()
    {
        $this->withoutExceptionHandling();

        $stagesCount = Stage::count();

        $response = $this->getJson('/api/stages');
        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonCount($stagesCount);
    }

    public function test_it_shows_the_list_of_stages_en_orden()
    {
        $this->withoutExceptionHandling();

        $response = $this->getJson('/api/stages');
        $response->assertStatus(Response::HTTP_OK);

        // verificamos si el orden es el correcto
        $ordenDeStages = collect(json_decode($response->getContent()))->pluck('order')->toArray();

        $this->assertEquals([1,2,3], $ordenDeStages);
    }
}
