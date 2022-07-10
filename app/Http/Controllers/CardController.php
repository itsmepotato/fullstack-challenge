<?php

namespace App\Http\Controllers;

use App\Card;
use App\Http\Requests\Card\StoreRequest;
use App\Http\Requests\Card\UpdateRequest;
use App\Services\Card\CreateCard;
use App\Services\Card\DeleteCard;
use App\Services\Card\ListCards;
use App\Services\Card\ListCardsByStages;
use App\Services\Card\UpdateCard;
use App\Stage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ListCards $listCards)
    {
        $cards = $listCards->execute(auth()->user());
        return response()->json($cards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, CreateCard $createCard)
    {
        $request['user_id'] = auth()->id();
        $card = $createCard->execute($request->all());

        return response()->json($card, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Card $card, UpdateCard $updateCard)
    {
        $request['user_id'] = auth()->id();
        $card = $updateCard->execute($card, $request->all());

        return response()->json($card, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card, DeleteCard $deleteCard)
    {
        $deleteCard->execute($card);
        return response()->json([], 204);
    }

    public function getCardsByStage(ListCardsByStages $listCardsByStages)
    {
        $cardsByStages = $listCardsByStages->execute(auth()->user());

        return response()->json($cardsByStages);
    }
}
