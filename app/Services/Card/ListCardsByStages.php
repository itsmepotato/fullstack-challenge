<?php

namespace App\Services\Card;

use App\Card;
use App\Contracts\IndexService;
use App\Stage;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class ListCardsByStages implements IndexService
{
    public function execute(User $user): Collection
    {
        return Stage::with('cardsOfCurrentUser')->get();
    }
}
