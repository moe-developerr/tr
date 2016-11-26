@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    	<div class="col-xs-12">
    		<ul class="lists-list">
                @foreach($board->lists as $list)
                <li class="list-item">
                    <div class="list">
                        <span class="list-name">{{ $list->name }}</span>
                        <span class="list-options-btn"></span>
                        @foreach($list->cards as $card)
                        <a href="#" class="card">
                            <span class="card-name">{{ $card->name }}</span>
                            <span class="card-options-btn fa fa-pencil-square"></span>
                        </a>
                        @endforeach
                    </div>
                </li>
                @endforeach
            </ul>
    	</div>
    </div>
</div>

<div class="card-content">
    <div class="card-close fa fa-close"></div>
    <div class="card-header">
        <span class="card-header-icon fa fa-window-maximize"></span>
        <span class="card-name"><strong></strong></span>
        <p>List created at <span class="card-date"></span></p>
    </div>
    <div class="card-body">
        <div class="add-comment-section">
            <div class="add-comment-header">
                <span class="add-comment-icon fa fa-comment-o"></span>
                <strong>Add Comment</strong>
            </div>
            <div class="add-comment-body">
                
            </div>
        </div>
        <div class="check-list">
            <span class="check-list-icon fa fa-check-square-o"></span>
            
        </div>

    </div>
</div>
@stop