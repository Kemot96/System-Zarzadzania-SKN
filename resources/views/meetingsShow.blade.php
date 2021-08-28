@extends('layouts.meetings')

@section('meetingsContent')
    <div class="col-8 text-center">
        <div>Temat: {{$meeting->topic}}</div>
        <div>Data: {{$meeting->created_at}}</div>
        @if(!isset($meeting->supervisor_approved))
            <div class="text-info font-weight-bold">Status: Rozpatrywane przez opiekuna</div>
        @elseif($meeting->supervisor_approved == TRUE)
            <div class="text-success font-weight-bold">Status: Zaakceptowane</div>
        @elseif($meeting->supervisor_approved == FALSE)
            <div class="text-danger font-weight-bold">Status: Odrzucone</div>
        @endif
        <div>Lista członków spotkania:</div>
        @foreach($meeting->present_members as $present_member)
            <div>{{$present_member}}</div>
        @endforeach
        <div class="row justify-content-center">
            @if($club->getLoggedUserRoleName() == 'opiekun_koła')
                @if(!isset($meeting->supervisor_approved))
                    <form action="{{ route('meetings.ActionAsSupervisor', [$club, $meeting])}}" method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" value="accept">
                        <button class="btn btn-success mr-1" type="submit">Zatwierdź</button>
                    </form>
                    <form action="{{ route('meetings.ActionAsSupervisor', [$club, $meeting])}}" method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" value="dismiss">
                        <button class="btn btn-danger mr-1" type="submit">Odrzuć</button>
                    </form>
                @else
                    <form action="{{ route('meetings.ActionAsSupervisor', [$club, $meeting])}}" method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" value="undo">
                        <button class="btn btn-primary mr-1" type="submit">Cofnij</button>
                    </form>
                @endif
            @endif
                <a href="{{ route('meetings.edit', [$club, $meeting])}}" class="btn btn-primary mr-1">Edytuj</a>
                <form action="{{ route('meetings.destroy', [$club, $meeting])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Jesteś pewien?')" class="btn btn-danger mr-1" type="submit">
                        Usuń
                    </button>
                </form>
        </div>
    </div>
@endsection
