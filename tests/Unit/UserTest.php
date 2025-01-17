<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_many_cards()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->cards);
    }
}
