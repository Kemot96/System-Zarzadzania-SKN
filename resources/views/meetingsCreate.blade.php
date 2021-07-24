@extends('layouts.layout')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dodaj spotkanie') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('meetings.store', $club) }}">
                            @csrf
                            <div class="form-group row">
                                <label for="topic"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Temat') }}</label>

                                <div class="col-md-6">
                                    <input id="topic" type="text"
                                           class="form-control @error('topic') is-invalid @enderror" name="topic"
                                           value="{{ old('topic') }}" required autocomplete="off" autofocus>

                                    @error('topic')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            @foreach($club_members as $club_member)
                            <div class="form-check">
                                <input name="present_club_members[]" class="form-check-input" type="checkbox" value="{{$club_member->user->name}}" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    {{$club_member->user->name}}
                                </label>
                            </div>
                            @endforeach


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Dodaj spotkanie') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
