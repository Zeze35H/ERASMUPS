@php
$pageName = 'Log In';
$loggedIn = false;
@endphp

@extends('layouts.app')

@section('content')
    <main id="sign_in">
        @if (session()->has('success'))
            <div class="row messages">
                <div class="offset-md-2 col-md-8 success">
                    <div class="close_button"><i class="fas fa-times"></i></div>
                    <p class="text_message"> {{ session()->get('success') }} </p>
                </div>
            </div>
        @endif

        @if ($passwordreset ?? '' == true)
            <div class="offset-md-2 col-md-8 success">
                <div class="close_button"><i class="fas fa-times"></i></div>
                <p class="text_message"> Your password reset was succesfull! </p>
            </div>
        @endif

        <div class="col-md-6 offset-md-3">
            <h2>Welcome back!</h2><br>
            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-row">
                    <div class="form-group col-md-6 offset-md-3">
                        <label for="inputEmail4">Email</label>
                        <input name="email" type="email" class="form-control" id="inputEmail4" placeholder=""
                            value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="error">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label for="inputPassword4">Password</label>
                        <input name="password" type="password" class="form-control" id="inputPassword4"
                            placeholder="" required>
                        @if ($errors->has('password'))
                            <span class="error">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="submit text-center">
                    <button id="submit" class="btn btn-default button_small" type="submit" value="Sign In">Sign In</button>
                </div>
            </form>
            &nbsp;
            <footer class="notes text-center">
                <a href="{{ route('recovery') }}">Forgot your password? Click Here! </a>
            </footer>
        </div>
    </main>
@endsection
