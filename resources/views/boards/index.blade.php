@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <ul class="board-list">
                @foreach($boards as $board)
                <li class="col-sm-4 col-md-3">
                    <a href="/boards/{{ $board->id }}" class="board">
                        <span class="board-name">{{ $board->name }}</span>
                        <span class="board-star fa fa-star-o {{ $board->is_favorite == 1 ? 'active' : '' }}" data-token="{{ csrf_token() }}"></span>
                    </a>
                </li>
                @endforeach
                <li class="col-sm-4 col-md-3">
                    <div class="new-board-show">Create new board...</div>
                    <form class="new-board-form" action="/boards" method="POST">
                        <header class="new-board-header">
                            <span>Create Board</span>
                            <span class="new-board-hide"></span>
                        </header>
                        <div class="new-board-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="new-board-name" class="control-label">Title</label>
                                <input type="text" class="form-control" required="required" placeholder="New Board Name" name="name">
                            </div>
                            <button class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>
@stop