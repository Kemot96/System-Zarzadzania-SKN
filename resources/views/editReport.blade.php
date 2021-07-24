@extends('layouts.layout')

@section('content')

    <script src="https://cdn.tiny.cloud/1/l2jgkyuas2hqjvouzqo4u8u5f0vtgxfc3ycnzylyuvi6zr28/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea#editor',
            plugins: 'lists, autoresize',
            toolbar: 'bold italic strikethrough bullist numlist',
            menubar: false,
            forced_root_block : false,
        });
    </script>

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edycja sprawozdania') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clubReport.update',[$club,$report]) }}">
                        @method('PATCH')
                        @csrf
                        <div class="container mt-4 mb-4">
                            <div class="row justify-content-md-center">
                                <div class="col-md-12 col-lg-8">
                                    <h1 class="h2 mb-4">{{ __('Opis zrealizowanych działań') }}</h1>
                                    <div class="form-group">
                                        <textarea id="editor" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="off" autofocus>{{ $report->description }}</textarea>

                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror

                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Zatwierdź zmiany') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <br><a href="{{ route('clubReport.generate', [$club, $report])}}" class="btn btn-primary">Wygeneruj sprawozdanie</a>
                    @if($attachments_send == FALSE)
                    <form method="POST" action="{{ route('clubReport.submitToSupervisor',[$club,$report]) }}" enctype="multipart/form-data">
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
                    @elseif(isset($report->supervisor_approved) && $report->supervisor_approved == FALSE)
                        <div>Odrzucono przez opiekuna</div>
                        <div>Uwagi: {{$report->remarks}}</div>
                    @elseif(isset($report->secretariat_approved) && $report->secretariat_approved == FALSE)
                        <div>Odrzucono przez sekretariat</div>
                        <div>Uwagi: {{$report->remarks}}</div>
                    @elseif(isset($report['vice-rector_approved']) && $report['vice-rector_approved'] == FALSE)
                        <div>Odrzucono przez wice-rektora</div>
                        <div>Uwagi: {{$report->remarks}}</div>
                    @elseif($report->supervisor_approved == TRUE)
                        <div>Zaakceptowano przez opiekuna</div>
                    @endif

                    @if($attachments_send == TRUE)
                        <div>Wysłane pliki:</div>
                        @foreach($report->attachments as $attachment)
                            <a href="{{ route('downloadAttachment', ['path' => $attachment->name])}}">{{$attachment->original_file_name}}</a>
                        @endforeach
                    @endif
                    @if($attachments_send == TRUE)
                        <form method="POST" action="{{ route('clubReport.submitToSupervisor',[$club,$report]) }}" enctype="multipart/form-data">
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
    </div>
@endsection
