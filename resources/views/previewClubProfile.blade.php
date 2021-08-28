@extends('layouts.layout')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('clubMainPage.previewProfile', $club) }}
        <div>{!!$club->description!!}</div>
    </div>
@endsection
