<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />

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

    <style>
            table, td, tr {
                border: 2px solid black;
            }
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
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
            }

            p {
                font-family: 'Poppins', sans-serif;
                font-size: 1.1em;
                font-weight: 300;
                line-height: 1.7em;
                color: #999;
            }
    </style>

</head>
<body>
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

  @yield('content')
</div>
<script src="{{ asset('js/app.js') }}" type="text/js"></script>

<script src="{{ asset('js/sidebar.js') }}"></script>
<script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
</body>
</html>
