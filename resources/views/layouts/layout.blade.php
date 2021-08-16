<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Basic</title>
    <!-- CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet" type="text/css"/>


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}" type="text/css"/>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
            crossorigin="anonymous"></script>
    <script src="{{ asset('/js/dropzone.js') }} "></script>

    <style>
        table, td, tr {
            border: 2px solid black;
        }

        .remove-image {
            display: none;
            position: absolute;
            top: -10px;
            right: -1px;
            border-radius: 10em;
            padding: 2px 6px 3px;
            text-decoration: none;
            font: 700 21px/20px sans-serif;
            background: #555;
            border: 3px solid #fff;
            color: #FFF;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5), inset 0 2px 4px rgba(0, 0, 0, 0.3);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            -webkit-transition: background 0.5s;
            transition: background 0.5s;
        }

        .remove-image:hover {
            background: #E54E4E;
            padding: 3px 7px 5px;
            top: -11px;
            right: -2px;
        }

        .remove-image:active {
            background: #E54E4E;
            top: -10px;
            right: -2px;
        }

        .photo-gallery .photos {
            padding-bottom: 20px;
        }

        .photo-gallery .item {
            padding-bottom: 30px;
        }

    </style>

</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">

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
                        @if(Auth::user()->isAdministrator())
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

<main class="py-4">
    @yield('content')
</main>
<!-- Javascript -->
<script src="{{ asset('js/app.js') }}" type="text/js"></script>


<script src="{{ asset('js/sidebar.js') }}"></script>
<script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
</body>
</html>
