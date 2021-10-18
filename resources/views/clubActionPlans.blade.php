@extends('layouts.layout')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('clubActionPlan.menu', $club) }}


        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i
                                class="bi bi-file-earmark-font-fill"></i> Plan działań</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{ route('clubActionPlan.edit',[$club, $action_plan])}}" class="btn btn-primary">Go
                            somewhere</a>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="font-weight-bold">Archiwum:</h3>
        <div class="row">
            @foreach($action_plans as $archived_action_plan)
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-person"></i> Plan działań {{$archived_action_plan->academicYear->name}}</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="{{route('clubActionPlan.show', ['club' => $club, 'report' => $archived_action_plan])}}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

