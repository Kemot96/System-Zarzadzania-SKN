@extends('layouts.layout')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('clubReport.menu', $club) }}


        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i
                                class="bi bi-file-earmark-font-fill"></i> Sprawozdanie</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{ route('clubReport.edit',[$club, $report])}}" class="btn btn-primary">Go
                            somewhere</a>
                    </div>
                </div>
            </div>
        </div>
            <h3 class="font-weight-bold">Archiwum:</h3>
        <div class="row">
            @foreach($reports as $archived_report)
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person"></i> Sprawozdanie {{$archived_report->academicYear->name}}</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{route('clubReport.show', ['club' => $club, 'report' => $archived_report])}}" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

@endsection

