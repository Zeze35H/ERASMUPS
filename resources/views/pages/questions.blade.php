@php
    $pageName = "Q&As";
@endphp

@extends('layouts.app')

@section('content')
<script src="https://kit.fontawesome.com/bbe86cf3eb.js" crossorigin="anonymous"></script>
<main id="q_a">
    @if(session()->has('success'))
        <div class="row messages">
            <div class="offset-md-2 col-md-8 success">
                <div class="close_button"><i class="fas fa-times"></i></div>
                <p class="text_message"> {{session()->get('success')}} </p>
            </div>
        </div>
    @endif
   <div id="head">
      <h2 >Q&As</h2>
      <div id="add_question"><a type="button" href = {{url('questions/ask')}} >Ask a Question</a></div>
      <div id="description">
         <p id="explanation">Our questions are organized by tags which are keywords or labels that categorize each question with other, similar questions.</p>
         <p id="searchExplanation">Search questions using a tag name, username or words contained in their title or body.</p>
         <div class="mx-auto" style="width: 300px;">
            <form class="form-inline my-2 my-lg-0" method="GET" action="{{route('questions')}}">
                &nbsp;
                &nbsp;
                &nbsp;
                <input class="form-control mr-sm-2 " type="search" name="search" placeholder="Find Questions" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
      </div>
   </div>
   <div id="questions">
        @for($numQuestion = 0; $numQuestion < count($questions); $numQuestion++)
            @include('partials.question')
        @endfor
   </div>
   @if(count($questions) == 0)
    <div class="noneFound">
        <i class='fa fa-exclamation-triangle' aria-hidden="true"></i>
        <p>No questions were found based on your search. Try searching by something else.</p>
    </div>
    @endif
</main>
@endsection