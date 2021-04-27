@extends('layout')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edytuj sprawozdanie') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clubReport.update',[$club->id,$report->id]) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Opis zrealizowanych działań') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description"  required autocomplete="off" autofocus>{{ $report->description }}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remarks" class="col-md-4 col-form-label text-md-right">{{ __('Dodatkowe uwagi') }}</label>

                            <div class="col-md-6">
                                <textarea id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" autocomplete="off">{{ $report->remarks }}</textarea>

                                @error('remarks')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edytuj sprawozdanie') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <br><a href="{{ route('clubReport.generate', [$club, $report])}}" class="btn btn-primary">Wygeneruj sprawozdanie</a>

                    <div class="mb-3">
                        <label for="formFileMultiple" class="form-label">Prześlij sprawozdanie</label>
                        <input class="form-control" type="file" id="formFileMultiple" multiple>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
