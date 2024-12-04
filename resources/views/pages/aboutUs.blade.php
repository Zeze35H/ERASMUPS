@php
    $pageName = "About Us";
@endphp

@extends('layouts.app')

@section('content')
    <main id="about_us">
        <div id="img">
            <img id="cities_image" src= {{ asset('images/cities.png') }} class="img-fluid" alt="Several Cities"></img>
        </div>
        <h2>Enriching lives, opening minds.</h2><br>
        <div id="description">
            <p><img id="logo_in_text" src= {{ asset('images/logo.png') }} class="img-fluid" alt="Logo" ></img> is an open
            community for any student interested or already enrolled in the ERASMUS program. We
            help you get answers to your doubts and share your experience with others!</p>
        </div>
        <div id="browse_questions"><a type="button" href = {{url('/questions')}} >Browse questions</a></div>

    </main>
@endsection
