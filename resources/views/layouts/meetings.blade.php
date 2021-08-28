@extends('layouts.layout')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('meetings.index', $club) }}
        <div class="row">
        <div class="col-4">
        @foreach($meetings as $meeting)
            <a href="{{ route('meetings.show', [$club, $meeting])}}">{{$meeting->topic}} {{$meeting->created_at}}</a><br>
        @endforeach
            <a href="{{ route('meetings.create', $club)}}" class="btn btn-success">Dodaj nowe spotkanie</a>
            <div>{{ $meetings->links() }}</div>
        </div>

            @yield('meetingsContent')
        </div>
    </div>
@endsection
