@extends('layouts.adminLayout')

@section('content')

    <!-- Page Content -->
    <div id="content">

        <table class="table table-striped">
            <thead>
            <tr>
                <td>Nazwa</td>
                <td colspan="2">Akcje</td>
            </tr>
            </thead>
            <tbody>
            @foreach($institutes as $institute)
                <tr>
                    <td>{{$institute->name}}</td>
                    <td><a href="{{ route('institutes.edit',$institute)}}" class="btn btn-primary">Edytuj</a></td>
                    <td>
                        <form action="{{ route('institutes.destroy', $institute)}}" method="post">
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
        {{ $institutes->links() }}

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <a href="{{ route('institutes.create')}}" class="btn btn-success">Dodaj instytut</a>
        <a href="{{ url('/') }}" class="btn btn-success">Powrót na stronę główną</a>

    </div>
@endsection

