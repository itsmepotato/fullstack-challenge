<?php

namespace App\Services\Card;

use App\Card;
use App\Contracts\IndexService;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class ListCards implements IndexService
{
    public function execute(User $user): Collection
    {
        return Card::where('user_id', $user->id)->get();
    }
}
