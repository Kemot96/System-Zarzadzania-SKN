@extends('layouts.adminLayout')

@section('content')

    <!-- Page Content -->
    <div id="content">

        <table class="table table-striped">
            <thead>
            <tr>
                <td>Typ</td>
                <td>Treść</td>
                <td>Akcje</td>
            </tr>
            </thead>
            <tbody>
            @foreach($emails as $email)
                <tr>
                    <td>{{$email->type}}</td>
                    <td>{{$email->message}}</td>
                    <td><a href="{{ route('emails.edit',$email->id)}}" class="btn btn-primary">Edytuj</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $emails->links() }}

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <a href="{{ url('/') }}" class="btn btn-success">Powrót na stronę główną</a>

    </div>
@endsection

