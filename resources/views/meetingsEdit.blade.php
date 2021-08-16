@extends('layouts.meetings')

@section('meetingsContent')
    <div class="col-8">
        <form method="POST" action="{{ route('meetings.update', [$club, $meeting]) }}">
            @method('PATCH')
            @csrf
            <div class="form-group row">
                <label for="topic"
                       class="col-md-4 col-form-label text-md-right">{{ __('Temat') }}</label>

                <div class="col-md-6">
                    <input id="topic" type="text"
                           class="form-control @error('topic') is-invalid @enderror" name="topic"
                           value="{{$meeting->topic}}" required autocomplete="off" autofocus>

                    @error('topic')
                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>


            @foreach($club_members as $club_member)
                <div class="form-check">
                    <input name="present_members[]" class="form-check-input" type="checkbox" value="{{$club_member->user->name}}" id="defaultCheck1"
                    @foreach($meeting->present_members as $present_member)
                        @if($present_member == $club_member->user->name)
                    checked
                           @endif
                    @endforeach>
                    <label class="form-check-label" for="defaultCheck1">
                        {{$club_member->user->name}}
                    </label>
                </div>
            @endforeach


            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Edytuj spotkanie') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
