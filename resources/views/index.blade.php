@extends('layouts.layout')

@section('content')
    <div class="container">
        @if (Auth::check())
            <h1 class="text-center">Moje koła/sekcje:</h1>
            <ul class="list-group">
                @foreach($my_clubs as $my_club)
                    <li class="list-group-item d-md-flex d-lg-flex d-xl-flex justify-content-between align-items-center">
                        <h2><a href="{{ route('clubMainPage', ['club' => $my_club])}}">{{$my_club->name}}</a></h2>
                        @if(!$my_club->icon == NULL)
                            <div class="image-club">
                                <a href="{{ route('clubMainPage', ['club' => $my_club])}}">
                                    <img src="{{ asset('storage/' . $my_club->icon) }}" class="img-fluid img-thumbnail"
                                         alt=""></a>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>


            <h1 class="text-center">Inne:</h1>
            <ul class="list-group">
                @foreach($clubs as $club)
                    <li class="list-group-item d-md-flex d-lg-flex d-xl-flex justify-content-between align-items-center">
                        <h2><a href="{{ route('clubMainPage', ['club' => $club])}}">{{$club->name}}</a></h2>
                        @if(!$club->icon == NULL)
                        <div class="image-club">
                            <a href="{{ route('clubMainPage', ['club' => $club])}}">
                                <img src="{{ asset('storage/' . $club->icon) }}" class="img-fluid img-thumbnail" alt=""></a>
                        </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <ul class="list-group">
                @foreach($clubs as $club)
                    <li class="list-group-item d-md-flex d-lg-flex d-xl-flex justify-content-between align-items-center">
                        <h2><a href="{{ route('clubMainPage', ['club' => $club])}}">{{$club->name}}</a></h2>
                        @if(!$club->icon == NULL)
                        <div class="image-club">
                            <a href="{{ route('clubMainPage', ['club' => $club])}}">
                                <img src="{{ asset('storage/' . $club->icon) }}" class="img-fluid img-thumbnail" alt=""></a>
                        </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection





