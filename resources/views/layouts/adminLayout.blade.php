<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}" type="text/css"/>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
            crossorigin="anonymous"></script>

    <style>
        table, td, tr {
            border: 2px solid black;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .wrapper {
            display: flex;
            width: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #fafafa;
            margin-bottom: 100px; /* Margin bottom by footer height */
        }

        p {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1em;
            font-weight: 300;
            line-height: 1.7em;
            color: #999;
        }

        html {
            position: relative;
            min-height: 100%;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #eff2f4;
            color: #555;
            padding: 15px 0 15px;
        }
    </style>

</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand">
            <img src="{{ asset('storage/images/orzel.svg') }}" alt="Rzeczpospolita Polska (godło)">
        </a>

        <a class="navbar-brand" href="https://pwsz.elblag.pl">
            <img width="146" height="54" src="{{ asset('storage/images/logo-pwsz-www.png') }}"
                 alt="PWSZ w Elblągu (logo))">
        </a>

        <a class="navbar-brand" href="{{ url('/') }}">
            Strona główna
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">


            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @if (Route::has('login'))
                    @if (Auth::check())
                        @if(Auth::user()->isAdministrator() || Auth::user()->isSecretariat() || Auth::user()->isViceRector())
                            <li class="nav-item"><a href="{{ url('/admin/users') }}"
                                                    class="nav-link text-sm text-gray-700 underline">Panel
                                    administatora</a>
                            </li>
                        @endif
                        @if(Auth::user()->isSecretariat())
                            <li class="nav-item"><a href="{{ route('secretariat.showReports')}}"
                                                    class="nav-link text-sm text-gray-700 underline">Pisma czekające na
                                    akceptację</a></li>
                        @endif
                        @if(Auth::user()->isViceRector())
                            <li class="nav-item"><a href="{{ route('vice-rector.showReports')}}"
                                                    class="nav-link text-sm text-gray-700 underline">Pisma czekające na
                                    akceptację</a></li>
                        @endif
                    @endif
                @endif
            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Zaloguj się') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Zarejestruj się') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Wyloguj się') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>


        </div>
    </div>
</nav>
<div class="container">
    <!-- Sidebar -->
    <nav class="sidebar active">

        <!-- close sidebar menu -->
        <div class="dismiss">
            <i class="fas fa-arrow-left"></i>
        </div>

        <ul class="list-unstyled menu-elements">
            <li>
                <a href="{{route('users.index')}}">Użytkownicy</a>
            </li>
            <li>
                <a href="{{route('clubs.index')}}">Koła/sekcje</a>
            </li>
            <li>
                <a href="{{route('clubMembers.index')}}">Członkowie kół/sekcji</a>
            </li>
            <li>
                <a href="{{route('institutes.index')}}">Instytuty</a>
            </li>
            <li>
                <a href="{{route('emails.index')}}">Emaile</a>
            </li>
        </ul>
    </nav>
    <!-- End sidebar -->

    <!-- open sidebar menu -->
    <a class="btn btn-primary btn-customized open-menu" href="#" role="button">
        <i class="fas fa-align-left"></i> <span>Menu</span>
    </a>
    <main class="py-4">
        @yield('content')
    </main>
</div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-xs-12 text-center">{{ __('© 2018 Państwowa Wyższa Szkoła Zawodowa w Elblągu') }}</div>
            <div class="col-sm-2 col-xs-12 text-center"><b>{{ __('ISO 9001') }}</b></div>
            <div class="col-sm-4 col-xs-12 text-center"><a href="http://bip.pwsz.elblag.pl/" target="_blank">{{ __('Biuletyn
                        Informacji Publicznej') }} <img class="show_inline" src="{{ asset('storage/images/ico-bip.png') }}"
                                                        alt="BIP: Biuletyn Informacji Publicznej"><span class="sr-only">otwiera się w nowym oknie</span></a>
            </div>
        </div>
    </div> <!-- container -->
</footer>

<script src="{{ asset('js/app.js') }}" type="text/js"></script>

<script src="{{ asset('js/sidebar.js') }}"></script>
<script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
</body>
</html>
