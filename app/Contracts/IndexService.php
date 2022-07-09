<?php

namespace App\Contracts;

use App\User;
use Illuminate\Database\Eloquent\Collection;

interface IndexService
{
    public function execute(User $user): Collection;
}
