<?php

namespace App\Http\Controllers;

use App\Card;
use App\ListModel;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 3 queries
        $board = auth()->user()->boards();
        $boardId = ListModel::findOrFail($request->list_id);

        
        $card = new Card;
        $card->list_id = $request->list_id;
        $card->name = $request->name;
        $card->order = $request->order;
        $card->save();
        return response(['message' => [
            'name' => $card->name,
            'href' => '/cards/' . $card->id
        ], 'status' => 'success']);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        $card = Card::findOrFail($id);
        $card->name = $request->name;
        $card->save();
        return response(['message' => $request->name, 'status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        Card::findOrFail($id)->delete();
        return response(['message' => 'Card deleted', 'status' => 'success']);
    }
}
