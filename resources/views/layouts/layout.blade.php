<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Basic</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <style>

    </style>

</head>
<body>

<div class="container">
    <header class="d-flex flex-wrap py-3 mb-4 border-bottom">
        <ul class="nav nav-pills">
            @if (Route::has('login'))
                    @if (Auth::check())
                        @if(Auth::user()->isAdministrator())
                            <li class="nav-item"><a href="{{ url('/admin/users') }}" class="nav-link text-sm text-gray-700 underline">Panel administatora</a></li>
                        @endif
                        @if(Auth::user()->isSecretariat())
                                <li class="nav-item"><a href="{{ route('secretariat.showReports')}}" class="nav-link text-sm text-gray-700 underline">Pisma czekające na akceptację</a></li>
                        @endif
                        @if(Auth::user()->isViceRector())
                                <li class="nav-item"><a href="{{ route('vice-rector.showReports')}}" class="nav-link text-sm text-gray-700 underline">Pisma czekające na akceptację</a></li>
                        @endif
                    @endif

                    @auth
                            <li class="nav-item"><a href="{{ url('/dashboard') }}" class="nav-link text-sm text-gray-700 underline">Dashboard</a></li>
                    @else
                            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link text-sm text-gray-700 underline">Log in</a></li>
                        @if (Route::has('register'))
                                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link text-sm text-gray-700 underline">Register</a></li>
                        @endif
                    @endauth
            @endif
        </ul>
    </header>

    @yield('content')
</div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>
