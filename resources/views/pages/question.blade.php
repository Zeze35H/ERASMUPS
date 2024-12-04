@php
    $pageName = $question->title;
@endphp

@extends('layouts.app')

@section('content')
<main id="q_a_thread">
    <div class="row messages">
        @if(session()->has('success'))
            <div class="offset-md-2 col-md-8 success">
                <div class="close_button"><i class="fas fa-times"></i></div>
                <p class="text_message"> {{session()->get('success')}} </p>
            </div>
        @endif
    </div>
    @if($question->closed === true)
        <div class="offset-md-2 col-md-8 close_message"><i class="fa fa-check"></i> This Q&A was marked as solved! </div>
    @endif
    <div id="content_{{$id}}" class="question row" data-id={{$id}} data-type="question">
        <div class="col-md-2 question_opt">
            @php
                $type = explode('/', $question->user_path)[0];
                $userStatus;
                if ($question->deleted) $userStatus = 'deleteduser';
                else $userStatus = 'notdeleteduser';
            @endphp
            @if ($userStatus === 'deleteduser')
                <div class="user">
                    @if ($type === 'images')
                        <img class="avatar {{$userStatus}} deleted" src={{asset($question->user_path)}} alt="user profile picture" width="50" height="50"><br>
                    @else
                        <img class="avatar {{$userStatus}} deleted" src={{$question->user_path}} alt="user profile picture" width="50" height="50"><br>
                    @endif
                    <span class="{{$userStatus}}" style="font-style: italic;">Deleted User</span>
                </div>
            @else
                <div class="user">
                    @if($question->user_id === 1)
                        @if ($type === 'images')
                            <img class="avatar {{$userStatus}}" src={{asset($question->user_path)}} alt="user profile picture" width="50" height="50"><br>
                        @else
                            <img class="avatar {{$userStatus}}" src={{$question->user_path}} alt="user profile picture" width="50" height="50"><br>
                        @endif
                        <span class="deleteduser">{{$question->username}}</span>
                    @else
                        <a href="{{url('user/'.$question->user_id)}}" style="text-decoration: none;">
                            @if ($type === 'images')
                                <img class="avatar {{$userStatus}}" src={{asset($question->user_path)}} alt="user profile picture" width="50" height="50"><br>
                            @else
                                <img class="avatar {{$userStatus}}" src={{$question->user_path}} alt="user profile picture" width="50" height="50"><br>
                            @endif
                            <span class="{{$userStatus}}">{{$question->username}}</span>
                        </a>
                    @endif
                </div>
            @endif
            <div class="score">
                @if ($question->votes === true)
                    @if ($userLoggedIn !== $question->username && $userLoggedIn != null) 
                        <i class="fas fa-chevron-up canvote up votedUp" id="true"></i>
                    @else
                        <i class="fas fa-chevron-up cannotvote" id="true"></i>
                    @endif
                @elseif ($question->votes === false || $question->votes === null)
                    @if ($userLoggedIn !== $question->username && $userLoggedIn != null) 
                        <i class="fas fa-chevron-up canvote up" id="true"></i>
                    @else
                        <i class="fas fa-chevron-up cannotvote" id="true"></i>
                    @endif
                @endif
                <span>{{$question->score}}</span>
                @if ($question->votes === false)
                    @if ($userLoggedIn !== $question->username && $userLoggedIn != null) 
                        <i class="fas fa-chevron-down canvote down votedDown" id="false"></i>
                    @else
                        <i class="fas fa-chevron-down cannotvote" id="false"></i>
                    @endif
                @elseif ($question->votes === true || $question->votes === null)
                    @if ($userLoggedIn !== $question->username && $userLoggedIn != null) 
                        <i class="fas fa-chevron-down canvote down" id="false"></i>
                    @else
                        <i class="fas fa-chevron-down cannotvote" id="false"></i>
                    @endif
                @endif
                
            </div>
            <div class="signs" data-id="{{$question->id}}">
                <div class="edit">
                    @if ($userLoggedIn === $question->username || $mod === true || $admin === true)
                        <i class="fas fa-pencil-alt canedit"></i>
                    @endif
                </div>
                <div class="reports">
                    @if ($userLoggedIn != null)
                        @if ($userLoggedIn !== $question->username && array_search($question->id, $hasReportedList) === false)
                            <i data-toggle="modal" data-target="#popupquestion{{$question->id}}" class="far fa-flag canreport"></i>
                            @include('partials.report_popup', ['type' => "question", 'id' => $question->id])
                        @elseif($userLoggedIn !== $question->username && $userStatus !== 'deleteduser')
                            <i class="far fa-flag cannotreport" style="display:inline-block;color:red"></i>
                        @endif
                    @endif
                </div>
                <div class="remove">
                    @if ($userLoggedIn === $question->username)
                    <form method="POST" action="{{ route('removeQuestion', [$question->id]) }}">
                        {{ csrf_field() }} @method('delete')
                        <button type="submit"><i class="far fa-trash-alt canremove"></i></button>
                    </form>
                    @else
                        <i class="far fa-trash-alt cannotremove"></i>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8 card question_body">
            <div class="card-body notedit" contenteditable='false'>
                <h1 class="card-title">{{$question->title}}</h1>
                <p class="card-text" >{{$question->text}}</p>
                <div class="question_images" contenteditable='false'>
                    @if($question->question_path !== " ")
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#popupimage"><i class="fas fa-images"></i> View Images </button>
                        @include('partials.image_popup')
                    @endif
                </div>
                &nbsp;
                <div class="date" contenteditable='false'>
                    <p style="margin-bottom: 0"><small style="color: grey">Created at: {{$question->created_at}}</small></p>
                    @if ($question->created_at !== $question->edited_at)    
                        <p style="margin-bottom: 0"><small style="color: grey">Edited at: {{$question->edited_at}}</small></p>
                    @endif
                </div>
                <div style="margin-top: 1rem" id="tags">
                    <p hidden>{{$question->tags}}</p>
                    @include('partials.tags', ['tags_string' => $question->tags, 'close' => false])
                </div>
            </div>
            <div class="card-body edit" hidden>
                <form>
                    {{ csrf_field() }}
                    @if ($userLoggedIn === $question->username)
                        <div><label>Title: </label><input style="margin-top: 0.7em; width: 100%" name="title" type="text" value='{{$question->title}}'></div>
                        <div><label>Body: </label><textarea style="margin-top: 0.7em" cols="100" name="text" class="form-control" rows="5">{{$question->text}}</textarea></div>
                    @else
                        <h1 class="card-title">{{$question->title}}</h1>
                        <p class="card-text" >{{$question->text}}</p>  
                    @endif
                    <div><label>Tags: </label><input style="margin-top: 0.7em; width: 100%" name="tags" type="text" value='{{$question->tags}}'></div>
                    <div><button class="btn btn-green" type="submit">Done</button><button class="btn btn-red" type="button">Cancel</button></div>
                </form>
            </div>
        </div>   
    </div>
    <section class="answers">
        @foreach($answers as $answer)
            @include('partials.answer')
        @endforeach
    </section>
    @if ($userLoggedIn !== $question->username && $userLoggedIn != null && $question->closed == false)
        <div class="row add_answer_form">
            <div class="col-md-8 offset-md-2" style="padding: 0;">
                <form data-id="{{$question->id}}" class="post_answer" method="POST" action="{{ route('addAnswer', [$question->id]) }}">
                    {{ csrf_field() }} @method('PUT')

                    <textarea name="text_answer" class="form-control" id="exampleFormControlTextarea1"  placeholder="Answer this question"></textarea>
                    @if ($errors->has('text_answer'))
                        <span class="error">
                            An answer can not be empty!
                        </span>
                    @endif
                    <button type="submit" class="btn btn-default button_small">Post Answer</button>
                </form>
            </div>
        </div>
    @endif
    
    @if (($userLoggedIn === $question->username || $mod === true || $admin === true) && $question->closed == false)
    <hr class="border-light m-0">
    &nbsp;
        <div class="d-flex justify-content-center close_section">
            <button type="submit" class="btn btn-green close_topic">Mark as Solved</button>
        </div>
    @endif
</main>
@endsection