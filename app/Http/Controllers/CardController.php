<?php

namespace App\Http\Controllers;

use App\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = Card::where('user_id', auth()->id())
                    ->get();

        return response()->json($cards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'delivery_date' => 'required|date',
            'stage_id' => 'required'
        ]);

        $card = Card::create([
            'name' => $request['name'],
            'delivery_date' => $request['delivery_date'],
            'stage_id' => $request['stage_id'],
            'user_id' => auth()->id(),
        ]);

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
    public function update(Request $request, Card $card)
    {
        // $request->validate([

        // ]);

        $card->update([
            'name' => $request['name'],
            'delivery_date' => $request['delivery_date'],
            'stage_id' => $request['stage_id'],
            'user_id' => auth()->id(),
        ]);

        return response()->json($card, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        $card->delete();
        return response()->json([], 204);
    }
}
