@extends('layouts.adminLayout')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edytuj członka klubu') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('clubMembers.update', $clubMember->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group row align-items-center">
                            <label for="clubs_id" class="col-md-4 col-form-label text-md-right">{{ __('Użytkownik') }}</label>

                            <div class="col-md-6">
                                {{$clubMember->user->name}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="roles_id" class="col-md-4 col-form-label text-md-right">{{ __('Rola') }}</label>

                            <div class="col-md-6">
                                <select id="roles_id" class="form-control @error('roles_id') is-invalid @enderror" name="roles_id">
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" @if($clubMember->roles_id == $role->id) selected="selected" @endif>{{$role->name}}</option>
                                    @endforeach
                                </select>

                                @error('roles_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="clubs_id" class="col-md-4 col-form-label text-md-right">{{ __('Klub') }}</label>

                            <div class="col-md-6">
                                <select id="clubs_id" class="form-control @error('clubs_id') is-invalid @enderror" name="clubs_id">
                                    @foreach($clubs as $club)
                                        <option value="{{$club->id}}" @if($clubMember->clubs_id == $club->id) selected="selected" @endif>{{$club->name}}</option>
                                    @endforeach
                                </select>

                                @error('clubs_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="academic_years_id" class="col-md-4 col-form-label text-md-right">{{ __('Rok akademicki') }}</label>

                            <div class="col-md-6">
                                <select id="academic_years_id" class="form-control @error('academic_years_id') is-invalid @enderror" name="academic_years_id">
                                    @foreach($academic_years as $academic_year)
                                        <option value="{{$academic_year->id}}" @if($clubMember->academic_years_id == $academic_year->id) selected="selected" @endif>{{$academic_year->name}}</option>
                                    @endforeach
                                </select>

                                @error('academic_years_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edytuj członka klubu') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
