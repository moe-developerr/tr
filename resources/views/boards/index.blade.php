@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <ul class="board-list">
                @foreach($boards as $board)
                <li class="board-wrapper col-sm-4 col-md-3">
                    <a href="/boards/{{ $board->id }}" class="board">
                        <span class="board-name">{{ $board->name }}</span>
                        <span class="favorite-board {{ $board->pivot->is_favorite == 1 ? 'active' : '' }}"></span>
                        <span class="delete-board"></span>
                    </a>
                </li>
                @endforeach
                <li class="col-sm-4 col-md-3">
                    <div class="create-board-show">Create new board...</div>
                    <form class="create-board-form" action="/boards" method="POST">
                        {{ csrf_field() }}
                        <header class="create-board-header">
                            <span>Create Board</span>
                            <span class="create-board-hide"></span>
                        </header>
                        <div class="create-board-body">
                            <div class="form-group">
                                <label for="board-name" class="control-label">Title</label>
                                <input type="text" id="board-name" class="board-name form-control" required="required" placeholder="New Board Name" name="name">
                            </div>
                            <button class="store-board btn btn-primary">Create</button>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>
@stop