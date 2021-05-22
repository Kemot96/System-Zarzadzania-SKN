@extends('layouts.layout')

@section('content')

    <!-- Page Content -->
    <div id="content">

        <table class="table table-striped">
            <thead>
            <tr>
                <td>Osoba składające sprawozdanie</td>
                <td>Typ sprawozdania</td>
                <td>Załączniki</td>
                <td colspan="2">Akcje</td>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{$report->user->name}}</td>
                    <td>{{$report->type->name}}</td>
                    <td>
                        @foreach($report->attachments as $attachment)
                            {{$attachment->name}}
                        @endforeach
                    </td>
                    @if(!isset($report->secretariat_approved))
                        <td>
                            <form action="{{ route('secretariat.reportAction', [$report->id])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="accept">
                                <button class="btn btn-success" type="submit">Zatwierdź</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('secretariat.reportAction', [$report->id])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="dismiss">
                                <button class="btn btn-danger" type="submit">Odrzuć</button>
                            </form>
                        </td>
                    @elseif($report->secretariat_approved == TRUE)
                        <td>
                            Zaakceptowano
                        </td>
                        <td>
                            <form action="{{ route('secretariat.reportAction', [$report->id])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="undo">
                                <button class="btn btn-danger" type="submit">Cofnij akcję</button>
                            </form>
                        </td>
                    @elseif($report->secretariat_approved == FALSE)
                        <td>
                            Odrzucono
                        </td>
                        <td>
                            <form action="{{ route('secretariat.reportAction', [$report->id])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="undo">
                                <button class="btn btn-danger" type="submit">Cofnij akcję</button>
                            </form>
                        </td>
                    @endif

                </tr>
            @endforeach
            </tbody>
        </table>
        <a href="{{ url('/') }}" class="btn btn-success">Powrót na stronę główną</a>
    </div>
@endsection

