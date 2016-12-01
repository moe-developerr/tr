<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards = Board::where('user_id', Auth::id())->get();
        return view('boards/index', compact('boards'));
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
        $board = new Board;
        $board->user_id = $request->user()->id;
        $board->name = $request->name;
        $board->save();
        return redirect('/boards/' . $board->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $board = Board::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        return view('boards/show', compact('board'));
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
        $board = Board::findOrFail($id);
        if(isset($request->is_favorite)) $board->is_favorite = $request->is_favorite;
        if(isset($request->name)) $board->name = $request->name;

        $board->save();
        return response(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Board::findOrFail($id)->delete();
        return response(['status' => 'success']);
    }
}
