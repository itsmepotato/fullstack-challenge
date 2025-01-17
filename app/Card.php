<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $guarded = [];

    // relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
