@php
    $pageName = "Mods Dashboard";
@endphp

@extends('layouts.app')

@section('content')
    <main id="mods_dashboard">
        
        <div id="head">
            <h2>Mods Dashboard</h2><br>
            <div id="description">
                <p>Check the list of mods on the website.</p>
                <p>You can also search for users/mods to manage them.</p>
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
                                <th class="text-center"><span>Number of Interactions</span></th>
                                <th class="text-center"><span>Action</span></th>
                                </tr>
                            </thead>
                            @if(count($allMods) !== 0)
                                <tbody>
                                    @for($numMod = 0; $numMod < count($allMods); $numMod++)
                                        @include('partials.mods')
                                    @endfor      
                                </tbody>
                            @endif
                        </table>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        @if(count($allMods) === 0)
            <div class="offset-md-2 col-md-8 empty_message">Mods list is empty.</div>
        @endif
    </main>
    @endsection