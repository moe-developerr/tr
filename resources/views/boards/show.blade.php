@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    	<ul class="lists-list">
            @foreach($board->lists as $list)
            <li class="list-item">
                <div class="list" data-id="{{ $list->id }}">
                    <div class="list-header">
                        <span class="list-name"><strong>{{ $list->name }}</strong></span>
                        <span class="list-options-btn"></span>
                    </div>
                    @foreach($list->cards as $card)
                    <a href="/cards/{{ $card->id }}" class="card">
                        <span class="card-name">{{ $card->name }}</span>
                        <span class="edit-card"></span>
                        <span class="delete-card"></span>
                    </a>
                    @endforeach
                    <a href="#" class="create-card">Add a card...</a>
                    <div class="store-card-section">
                        <header class="store-card-header">
                            <span>Create Card</span>
                            <span class="store-card-hide"></span>
                        </header>
                        <div class="store-card-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="store-card-name" class="control-label">Title</label>
                                <input type="text" class="form-control card-name" required="required" placeholder="New Card Name" name="name">
                            </div>
                            <button class="btn btn-primary store-card">Create</button>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
        <div class="col-xs-12">
            <div class="edit-card-section">
                <header class="edit-card-header">
                    <span>Update Card</span>
                    <span class="edit-card-hide"></span>
                </header>
                <div class="edit-card-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="edit-card-name" class="control-label">Title</label>
                        <input type="text" class="form-control card-name" required="required" placeholder="Card Name" name="name">
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
                    <div class="add-comment-section">
                        <div class="add-comment-header">
                            <span class="add-comment-icon"></span>
                            <strong>Add Comment</strong>
                        </div>
                        <div class="add-comment-body">
                            <textarea name="comment" id="comment" cols="30" rows="10" class="add-comment-message" placeholder="Write a comment..."></textarea>
                            <button class="add-comment-btn">Send</button>
                        </div>
                    </div>
                    <div class="check-list-section">
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