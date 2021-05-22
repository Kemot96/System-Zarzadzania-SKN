@extends('layouts.layout')

@section('content')

    <!-- Page Content -->
    <div id="content">

        <table class="table table-striped">
            <thead>
            <tr>
                <td>Użytkownik</td>
                <td>Rola</td>
                <td colspan="2">Akcje</td>
            </tr>
            </thead>
            <tbody>
            @foreach($club_members as $club_member)
                <tr>
                    <td>{{$club_member->user->name}}</td>
                    <td>{{$club_member->role->name}}</td>
                    <td>
                        @if($club_member->role->name == 'nieaktywny')
                            <form action="{{ route('clubMembers.update2', [$club, $club_member->id])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success" type="submit">Zatwierdź</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('clubMembers.destroy2', [$club, $club_member->id])}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Jesteś pewien?')" class="btn btn-danger" type="submit">Usuń</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ url('/') }}" class="btn btn-success">Powrót na stronę główną</a>
    </div>
@endsection

