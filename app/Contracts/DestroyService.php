<?php

namespace App\Contracts;

use App\Card;

interface DestroyService
{
    public function execute(Card $card): void;
}
