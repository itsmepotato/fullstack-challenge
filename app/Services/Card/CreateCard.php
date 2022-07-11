<?php

namespace App\Services\Card;

use App\Card;
use App\Contracts\CreateService;

class CreateCard implements CreateService
{
    public function execute(array $data): Card
    {
        $card = new Card();
        $card->name = $data['name'];
        $card->delivery_date = $data['delivery_date'];
        $card->stage_id = $data['stage_id'];
        $card->user_id = $data['user_id'];
        $card->delivered_at = $data['delivered_at'] ?? null;
        $card->save();

        return $card;
    }
}
