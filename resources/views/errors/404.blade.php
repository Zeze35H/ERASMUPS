@php
    $pageName = "Not Found";
@endphp

@extends('layouts.app')

@section('content')
    <main id="not_found">
      
          
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!------ Include the above in your HEAD tag ---------->
        
        <div class="page-wrap d-flex flex-row align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <div id="img">
                            <img id="error_image" src= {{ asset('images/404.png') }} class="img-fluid" alt="404 error"></img>
                        </div>
                        <div class="mb-4 lead">The page you are looking for was not found.</div>
                    </div>
                </div>
            </div>
        </div>
        <div id="browse_questions"><a type="button" href = {{url('/questions')}} >Browse questions</a></div>
    </main>
@endsection