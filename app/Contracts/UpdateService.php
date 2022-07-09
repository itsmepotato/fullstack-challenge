<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface UpdateService
{
    public function execute(Model $model, array $data): Model;
}
