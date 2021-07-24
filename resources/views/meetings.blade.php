@extends('layouts.layout')

@section('content')
    <div class="container">
        @foreach($meetings as $meeting)
            <a href="{{ route('meetings.show', [$club, $meeting])}}">{{$meeting->topic}}</a><br>
        @endforeach

            <a href="{{ route('meetings.create', $club)}}" class="btn btn-success">Dodaj nowe spotkanie</a>
    </div>
@endsection
