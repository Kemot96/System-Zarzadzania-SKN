@extends('layouts.layout')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('spendingPlan.menu', $club) }}


        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i
                                class="bi bi-file-earmark-font-fill"></i> Plan wydatków</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{ route('spendingPlan.edit',[$club, $spending_plan])}}" class="btn btn-primary">Go
                            somewhere</a>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="font-weight-bold">Archiwum:</h3>
        <div class="row">
            @foreach($spending_plans as $archived_spending_plan)
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-person"></i> Plan wydatków {{$archived_spending_plan->academicYear->name}}</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="{{route('spendingPlan.show', ['club' => $club, 'report' => $archived_spending_plan])}}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

