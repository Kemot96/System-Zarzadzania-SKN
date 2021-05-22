@extends('layouts.layout')

@section('content')


    <div class="row row-cols-4">
        @foreach($clubs as $club)
            <div class="col-xs-12 col-sm-3 col-md-3 mb-40 xs-margin-bottom-20px">
                <a href="{{ route('clubMainPage', ['club' => $club])}}">
                    <img src="{{ asset('storage/' . $club->icon) }}" class="img-thumbnail w-100" alt="" style=""></a>
                <a href="{{ route('clubMainPage', ['club' => $club])}}">{{$club->name}}</a>
            </div>
        @endforeach
    </div>

@endsection
