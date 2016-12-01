@extends('layouts.app')

@section('content')
<div class="container" id="board" data-board-id="{{ $board->id }}">
    <div class="row">
        <div class="col-xs-12">
            <span class="board-name">{{ $board->name }}</span>
            <button class="rename-board">Rename</button>
        </div>
    	<div class="col-xs-12">
            <ul class="lists row">
                @foreach($board->lists as $list)
                <li class="list-wrapper">
                    <div class="list" data-list-id="{{ $list->id }}">
                        <div class="list-header">
                            <span><strong class="list-name">{{ $list->name }}</strong></span>
                            <button class="rename-list">Rename</button>
                            <span class="delete-list"></span>
                        </div>
                        @foreach($list->cards as $card)
                        <a href="/cards/{{ $card->id }}" class="card">
                            <span class="card-name">{{ $card->name }}</span>
                            <span class="edit-card"></span>
                            <span class="delete-card"></span>
                        </a>
                        @endforeach
                        <a href="#" class="create-card">Add a card...</a>
                        <div class="create-card-form">
                            <header class="create-card-header">
                                <span>Create Card</span>
                                <span class="create-card-hide"></span>
                            </header>
                            <div class="create-card-body">
                                <div class="form-group">
                                    <label for="create-card-name-{{$list->id}}" class="control-label">Title</label>
                                    <input type="text" id="create-card-name-{{$list->id}}" class="form-control card-name" required="required" placeholder="New Card Name" name="name">
                                </div>
                                <button class="btn btn-primary store-card">Create</button>
                            </div>
                        </div>
                    </div> 
                </li>
                @endforeach
                <li class="list-wrapper create-list-wrapper">
                    <div class="list">
                        <div class="create-list">Add a list...</div>
                        <div class="create-list-form">
                            <header class="create-list-header">
                                <span>Create List</span>
                                <span class="create-list-hide"></span>
                            </header>
                            <div class="create-list-body">
                                <div class="form-group">
                                    <label for="create-list-name" class="control-label">Title</label>
                                    <input type="text" id="create-list-name" class="form-control list-name" required="required" placeholder="New List Name" name="name">
                                </div>
                                <button class="btn btn-primary store-list">Create</button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-xs-12">
            <div class="edit-card-form">
                <header class="edit-card-header">
                    <span>Update Card</span>
                    <span class="edit-card-hide"></span>
                </header>
                <div class="edit-card-body">
                    <div class="form-group">
                        <label for="edit-card-name" class="control-label">Title</label>
                        <input type="text" id="edit-card-name" class="form-control card-name" required="required" placeholder="Card Name" name="name">
                    </div>
                    <button class="btn btn-primary update-card">Update</button>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="card-content">
                <div class="card-content-hide"></div>
                <div class="card-content-header">
                    <span class="card-content-header-icon"></span>
                    <span class="card-name"><strong>Card Name</strong></span>
                    <p>List created at <span class="card-creation-date">07 Nov 2016</span></p>
                </div>
                <div class="card-body">
                    <div class="add-comment-form">
                        <div class="add-comment-header">
                            <span class="add-comment-icon"></span>
                            <strong>Add Comment</strong>
                        </div>
                        <div class="add-comment-body">
                            <textarea name="comment" id="comment" cols="30" rows="10" class="add-comment-message" placeholder="Write a comment..."></textarea>
                            <button class="add-comment-btn">Send</button>
                        </div>
                    </div>
                    <div class="check-list-form">
                        <div class="check-list-header">
                            <span class="check-list-icon"></span>
                            <strong>Checklist Name</strong>
                        </div>
                        <div class="check-list-body">
                            <ul class="check-list">
                                <li class="check-list-item">
                                    <span class="check-list-text">Check list Item</span>
                                    <span class="check-list-edit"></span>
                                    <span class="check-list-delete"></span>
                                </li>
                                <li class="check-list-item">
                                    <span class="check-list-text">Check list Item</span>
                                    <span class="check-list-edit"></span>
                                    <span class="check-list-delete"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
            
                </div>
            </div>
        </div>
    </div>
</div>
@stop