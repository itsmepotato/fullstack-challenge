<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function loginAsARandomUser(): User
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        return $user;
    }
}
