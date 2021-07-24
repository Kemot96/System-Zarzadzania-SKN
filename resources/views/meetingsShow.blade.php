@extends('layouts.layout')

@section('content')
    <div class="container">
        <div>Temat: {{$meeting->topic}}</div>
        <div>Data: {{$meeting->created_at}}</div>
        <div>Lista członków spotkania: </div>
        @foreach($meeting->present_members as $present_member)
        <div>{{$present_member}}</div>
        @endforeach
    </div>
@endsection
