@extends('layouts.layout')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('clubMainPage', $club) }}


        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person"></i> Lista członków koła</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{route('listClubMembers.index', ['club' => $club])}}" class="btn btn-primary">Go
                            somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person"></i> Pliki</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{route('clubFilesPage', ['club' => $club])}}" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i
                                class="bi bi-file-earmark-font-fill"></i> Sprawozdanie</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{ route('clubReport.menu', $club)}}" class="btn btn-primary">Go
                            somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i
                                class="bi bi-file-earmark-text-fill"></i> Plany działań</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{ route('clubActionPlan.menu', $club)}}" class="btn btn-primary">Go
                            somewhere</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i
                                class="bi bi-file-earmark-spreadsheet-fill"></i> Plany wydatków</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{ route('spendingPlan.menu', $club)}}" class="btn btn-primary">Go
                            somewhere</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-file-text"></i> Podgląd profilu koła/sekcji</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="{{route('clubMainPage.previewProfile', ['club' => $club])}}" class="btn btn-primary">Go
                            somewhere</a>
                    </div>
                </div>
            </div>
            @if($club->getLoggedUserRoleName() == 'opiekun_koła' || $club->getLoggedUserRoleName() == 'przewodniczący_koła')
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-card-text"></i> Edytuj profil koła/sekcji</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional
                                content.</p>
                            <a href="{{ route('club.description.edit',$club)}}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-person-check"></i> Dziennik spotkań</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional
                                content.</p>
                            <a href="{{ route('meetings.index', $club)}}" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            @endif
            @if($club->getLoggedUserRoleName() == 'opiekun_koła')
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-home"></i> Pisma czekające na akceptację</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional
                                content.</p>
                            <a href="{{route('clubReport.showReportsForApproval', ['club' => $club])}}"
                               class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

