@extends('layouts.layout')

@section('content')
    <div class="container">
        @if (Auth::check())
            <h1 class="text-center">Moje koła/sekcje:</h1>
            <div class="photo-gallery">
                <div class="container">
                    <div class="row photos">
                        @foreach($my_clubs as $my_club)
                            <div class="col-sm-6 col-md-4 col-lg-3 item"><a
                                    href="{{ route('clubMainPage', ['club' => $my_club])}}"
                                    data-lightbox="photos"><img class="img-fluid"
                                                                src="{{ asset('storage/' . $my_club->icon) }}"></a>
                                <a href="{{ route('clubMainPage', ['club' => $my_club])}}">{{$my_club->name}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <h1 class="text-center">Inne:</h1>
            <div class="photo-gallery">
                <div class="container">
                    <div class="row photos">
                        @foreach($clubs as $club)
                            <div class="col-sm-6 col-md-4 col-lg-3 item"><a
                                    href="{{ route('clubMainPage', ['club' => $club])}}"
                                    data-lightbox="photos"><img class="img-fluid"
                                                                src="{{ asset('storage/' . $club->icon) }}"></a>
                                <a href="{{ route('clubMainPage', ['club' => $club])}}">{{$club->name}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="photo-gallery">
                <div class="container">
                    <div class="row photos">
                        @foreach($clubs as $club)
                            <div class="col-sm-6 col-md-4 col-lg-3 item"><a
                                    href="{{ route('clubMainPage', ['club' => $club])}}"
                                    data-lightbox="photos"><img class="img-fluid"
                                                                src="{{ asset('storage/' . $club->icon) }}"></a>
                                <a href="{{ route('clubMainPage', ['club' => $club])}}">{{$club->name}}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection





