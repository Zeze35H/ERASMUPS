@php
    $pageName = "Request Password Recovery";
    $loggedIn = false;

@endphp

@extends('layouts.app')

@section('content')
<main id="recovery">
    @if(session()->has('success'))
        <div class="row messages">
            <div class="offset-md-2 col-md-8 success">
                <div class="close_button"><i class="fas fa-times"></i></div>
                <p class="text_message"> {{session()->get('success')}} </p>
            </div>
        </div>
    @endif
    @if($sent==1)
        <div class="offset-md-2 col-md-8 success">
                <div class="close_button"><i id='close' class="fas fa-times"></i></div>
                <p class="text_message"> Your Token was sent to your email succesfully! </p>
        </div>
    @endif
    <div class="col-md-6 offset-md-3">
        <div class="head">
            <h2>Request Password Reset</h2><br>
            <p>Forgot your password? Enter your email to receive a token to reset your password.</p>
        </div>
        <form method='POST' class='sendEmail' action="{{ route('recoveryEmail') }}">
            {{ csrf_field() }}

            <div class="form-row">
                <div class="form-group col-md-6 offset-md-3">
                    <label for="inputEmail4">Email</label>
                    <input name="email" type="text" class="form-control" id="inputEmail4" placeholder="Email" value="" required>
                    @if ($errors->has('email'))
                        <span class="error">
                        {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="submit text-center">
                <button id="submit" class="btn btn-default button_small" type="submit">Request Reset</button>
            </div> 
        </form>
        <div class='info'>
            <p>Remember to check the spam folder on your email. If you didn't get any email resend it using the button above.</p>
        </div>
        <form method='GET' class='sendEmail' action="{{ route('resetPassword') }}">
            {{ csrf_field() }}

            <div class="form-row">
                <div class="form-group col-md-6 offset-md-3">
                    <label for="tokenName">Token</label>
                    <input name="token" type="text" class="form-control" id="tok" placeholder="Token" value="" required>
                </div>
            </div>

            <div class="submit text-center">
                <button id="submit" class="btn btn-default button_small" type="submit">Submit Token</button>
            </div> 
        </form>
    </div>
</main>
@endsection
