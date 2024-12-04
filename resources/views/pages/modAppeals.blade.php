@php
    $pageName = "Mod Appeals";
@endphp

@extends('layouts.app')

@section('content')
    <main id="mod_appeals">
        
        <div id="head">
            <h2>Mod Appeals</h2><br>
            <div id="description">
                <p>Check the appeals and analyze the user and their overall activity before accepting their appeal.</p>
            </div>
        </div>
        <form id="search">
            <div class="mx-auto" style="width: 300px;">
                <form class="form-inline my-2 my-lg-0">
                    <input  class="form-control mr-sm-2" type="search" placeholder="Username" aria-label="Search">
                    <button class="btn btn-outline-success my-2" type="submit">Search</button>
                </form>
            </div>
        </form>
        <div class="row messages">
        </div>
        <div id="body">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-box clearfix">
                    <div class="table-responsive">
                        <table class="table user-list">
                            <thead>
                                <tr>
                                <th><span>User</span></th>
                                <th class="text-center"><span>Trust Level</span></th>
                                <th class="text-center"><span>Country</span></th>
                                <th class="text-center"><span>Action</span></th>
                                </tr>
                            </thead>
                            @if(count($modApplications) !== 0)
                                <tbody>    
                                    @for($numMod = 0; $numMod < count($modApplications); $numMod++)
                                        @include('partials.appeals')
                                    @endfor
                                </tbody>
                            @endif
                        </table>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
            @if(count($modApplications) === 0)
                <div class="offset-md-2 col-md-8 empty_message">Mod Appeals list is empty.</div>
            @endif
        </div>
    </main>
@endsection