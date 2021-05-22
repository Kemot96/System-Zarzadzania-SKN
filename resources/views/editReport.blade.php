@extends('layouts.layout')

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


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edytuj sprawozdanie') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <br><a href="{{ route('clubReport.generate', [$club, $report])}}" class="btn btn-primary">Wygeneruj sprawozdanie</a>
                    @if($attachments_send == FALSE)
                    <form method="POST" action="{{ route('clubReport.submitToSupervisor',[$club->id,$report->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="action" value="submit">
                    <div class="mb-3">
                        <label for="formFileMultiple" class="form-label">Prześlij sprawozdanie</label>
                        <input class="form-control" type="file" id="attachments" name="attachments[]" multiple>
                    </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Prześlij do opiekuna') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @elseif($report->supervisor_approved == TRUE)
                        <div>Zaakceptowano przez opiekuna</div>
                        @elseif($attachments_send == TRUE)
                        <form method="POST" action="{{ route('clubReport.submitToSupervisor',[$club->id,$report->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="action" value="undo">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Cofnij wysyłanie') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endif

                </div>
            </div>
        </div>
    </div>
@endsection
