@extends('layouts.adminLayout')

@section('content')

    <!-- Page Content -->
    <div id="content">
        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <td>Użytkownik</td>
                <td>Rola</td>
                <td>Koło/sekcja</td>
                <td>Rok akademicki</td>
                <td colspan="2">Akcje</td>
            </tr>
            </thead>
            <tbody>
            <div class="row">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Wybierz koło/sekcję
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach($clubs as $select_club)
                        <a class="dropdown-item @if($select_club == Request()->club) active @endif"
                           href="{{route('clubMembers.index', ['club' => $select_club, 'academicYear' => $academicYear])}}">{{$select_club->name}}</a>
                    @endforeach
                </div>
            </div>

            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Wybierz rok akademicki
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach($academic_years as $select_academicYear)
                        <a class="dropdown-item @if($select_academicYear == Request()->academicYear) active @endif"
                           href="{{route('clubMembers.index', ['club' => $club, 'academicYear' => $select_academicYear])}}">{{$select_academicYear->name}}</a>
                    @endforeach
                </div>
            </div>
            </div>

            @foreach($club_members as $club_member)
                <tr>
                    <td>{{$club_member->user->name}}</td>
                    <td>{{$club_member->role->name}}</td>
                    <td>{{$club_member->club->name}}</td>
                    <td>{{$club_member->academicYear->name}}</td>
                    <td><a href="{{ route('clubMembers.edit',[$club, $academicYear, $club_member])}}" class="btn btn-primary">Edytuj</a>
                    </td>
                    <td>
                        <form action="{{ route('clubMembers.destroy', [$club, $academicYear, $club_member])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Jesteś pewien?')" class="btn btn-danger" type="submit">
                                Usuń
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        {{ $club_members->links() }}

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <a href="{{ route('clubMembers.create', [$club, $academicYear])}}" class="btn btn-success">Dodaj członka koła/sekcji</a>
        <a href="{{ route('clubMembers.generatePDF', [$club, $academicYear])}}" class="btn btn-primary">Wygeneruj raport członkostwa (PDF)</a>
        <a href="{{ route('clubMembers.generateDoc', [$club, $academicYear])}}" class="btn btn-primary">Wygeneruj raport członkostwa (Doc)</a>
    </div>
@endsection

