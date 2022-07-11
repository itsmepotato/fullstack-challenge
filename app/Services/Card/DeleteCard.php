<?php

namespace App\Services\Card;

use App\Card;
use App\Contracts\DestroyService;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class DeleteCard implements DestroyService
{
    public function execute(Card $card): void
    {
        $card->delete();
    }
}
