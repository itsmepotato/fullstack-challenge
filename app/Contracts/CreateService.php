<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface CreateService
{
    public function execute(array $data): Model;
}
