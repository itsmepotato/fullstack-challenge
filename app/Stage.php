<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    // relations
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
