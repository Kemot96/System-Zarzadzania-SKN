@extends('layouts.adminLayout')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dodaj członka koła/sekcji') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('clubMembers.store', [$club, $academicYear]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="clubs_id" class="col-md-4 col-form-label text-md-right">{{ __('Użytkownik') }}</label>

                            <div class="col-md-6">
                                <select id="users_id" class="form-control @error('users_id') is-invalid @enderror" name="users_id">
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>

                                @error('users_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="clubs_id" class="col-md-4 col-form-label text-md-right">{{ __('Rola') }}</label>

                            <div class="col-md-6">
                                <select id="roles_id" class="form-control @error('roles_id') is-invalid @enderror" name="roles_id">
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>

                                @error('roles_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Koło/Sekcja') }}</label>

                            <div class="col-md-6">
                                {{$club->name}}
                            </div>
                        </div>

                        <div class="form-group row align-items-center">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Rok akademicki') }}</label>

                            <div class="col-md-6">
                                {{$academicYear->name}}
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Dodaj członka koła/sekcji') }}
                                </button>
                                <a href="{{ route('clubMembers.index')}}" class="btn btn-danger">Anuluj</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
