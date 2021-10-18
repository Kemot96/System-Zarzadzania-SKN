@extends('layouts.layout')

@section('content')
    <div class="container">
        <div>{!!$club->description!!}</div>
        @if($request_to_join_send == false)
            <form method="POST" action="{{route('join', ['club' => $club])}}">
                @csrf
                <div class="form-group row mb-0 justify-content-center">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Dołącz do koła/sekcji') }}
                        </button>
                    </div>
                </div>
            </form>
        @endif
        @if($request_to_join_send == true)
            <div>Prośba o dołączenie została wysłana</div>
        @endif
    </div>
@endsection

