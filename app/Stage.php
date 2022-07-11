<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $table = 'stages';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public const BUFFER = "BUFFER";
    public const WORKING = "WORKING";
    public const DONE = "DONE";

    // relations
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function cardsOfCurrentUser()
    {
        return $this->cards()
                ->where('user_id', auth()->id())
                ->orderBy('updated_at', 'desc');
    }
}
