<?php

namespace App\Http\Controllers;

use App\ListModel;
use App\Board;
use Illuminate\Http\Request;

class ListsController extends Controller
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
        $list = new ListModel;
        if(isset($request->name)) $list->name = $request->name;
        if(isset($request->order)) $list->order = $request->order;
        if(isset($request->board_id)) $list->board_id = $request->board_id;

        if($list->board->user_id == $request->user()->id) {
            $list->save();
            return response([
                'list' => [
                    'id' => $list->id,
                    'name' => $list->name
                ],
                'status' => 'success'
            ]);
        }
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
        $list = ListModel::findOrFail($id);
        if(isset($request->name)) $list->name = $request->name;
        $list->save();
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
        $list = ListModel::findOrFail($id);
        $listBelongToAuthUser = ($list->board->user_id == Auth::id());

        if($listBelongToAuthUser) {
            $list->delete();
            return response(['status' => 'success']);
        }
    }
}
