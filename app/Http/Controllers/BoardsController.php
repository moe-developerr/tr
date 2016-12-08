<?php

namespace App\Http\Controllers;

use App\Board;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BoardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards = auth()->user()->boards;
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
        $board->name = $request->name;
        $board->save();
        $board->users()->attach(auth()->id());
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
        $board = Board::findOrFail($id);
        $isLoggedIn = !empty(auth()->user());
        $isPrivate = $board->is_private;
        $isAuthenticated = $isLoggedIn ? !empty(auth()->user()->boards()->findOrFail($id)) : false;
        if($isPrivate && !$isAuthenticated) return view('errors/private_board');
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
        $board = auth()->user()->boards()->findOrFail($id);
        if(isset($request->is_favorite)) {
            $board->pivot->is_favorite = $request->is_favorite;
            $board->pivot->save();
        }
        else if(isset($request->name)) {
            $board->name = $request->name;
            $board->save();
        }
        else if(isset($request->visibility)) {
            $board->visibility = $request->visibility;
            $board->save();
        }
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
        auth()->user()->boards()->findOrFail($id)->delete();
        return response(['status' => 'success']);
    }
}
