
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ERASMUPS') }} - {{ $pageName }} </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/style_common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_about_us.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_sign_in.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_sign_up.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_q_a.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_q_a_thread.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_edit_profile.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_ask_question.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_user_profile.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_other_profile.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_mod_appeals.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_reports.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_mods_dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_password_recovery.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style_error_pages.css') }}" rel="stylesheet">

    <link rel="icon" href="{{ asset('images/icon.png') }}">

    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>

    <script type="text/javascript" src={{ asset('js/common.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/q_a_thread.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/mod_appeals.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/reports.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/profile.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/password_recovery.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/mods_dashboard.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/questions.js') }} defer></script>
    <script type="text/javascript" src={{ asset('js/edit_profile.js') }} defer></script>

  </head>
  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand px-1" href={{ url('/aboutUs') }}>
            <img  src={{ asset('images/logo.png') }}  height="40" alt="Logo">
        </a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @include('partials.nav_bar')
      </nav>
    <header>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  
    @yield('content')
    @if ($loggedIn === true)

    @include('partials.notifications')
    @endif
    <footer class="main-footer"> &copy; ERASMUPS 2021 </footer>
  </body>
</html>
