@php
    $pageName = "Password Reset";
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
    @if($passwordreset ?? '' == 'false')
        <div class="offset-md-2 col-md-8 failure">
                <div class="close_button"><i id='close' class="fas fa-times"></i></div>
                <p class="text_message"> Could not update your password. Check your Token and all input fields </p>
        </div>
    @endif
    <div class="col-md-6 offset-md-3">
        <div class="head">
            <h2>Password Reset</h2><br>
            <p>Enter your new password.</p>
        </div>
        <form class='sendEmail' method='POST' action="{{ route('passwordUpdate') }}">
            {{ csrf_field() }}
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-row">
                <div class="form-group col-md-6 offset-md-3">
                    <label for="inputEmail4">Email</label>
                    <input name="email" type="text" class="form-control" id="inputEmail4" placeholder="Email" value="{{old('email')}}" required>
                    @if ($errors->has('email'))
                        <span class="error">
                        {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>
                <div class="form-group col-md-6 offset-md-3">
                  <label for="inputPassword4">Password</label>
                  <input name="password" type="password" class="form-control" id="inputPassword4" placeholder="*******" required>
                    @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>
                <div class="form-group col-md-6 offset-md-3">
                  <label for="inputPassword4">Confirm Password</label>
                  <input name="password_confirmation" type="password" class="form-control" id="inputPassword4" placeholder="*******" required>
                </div>

                

            </div>

            <div class="submit text-center">
                <button id="submit" class="btn btn-default button_small" type="submit">Submit Password</button>
            </div> 
        </form>
    </div>
</main>
@endsection
