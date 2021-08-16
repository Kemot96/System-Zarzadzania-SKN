@extends('layouts.layout')

@section('content')

    <script src="https://cdn.tiny.cloud/1/l2jgkyuas2hqjvouzqo4u8u5f0vtgxfc3ycnzylyuvi6zr28/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea#editor',
            plugins: 'lists, autoresize',
            toolbar: 'bold italic strikethrough bullist numlist',
            menubar: false,
            forced_root_block: false,
        });
    </script>

    <script>
        Dropzone.options.dropzoneSendFiles = {
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 20,
            maxFiles: 20,
            dictDefaultMessage: 'Upuść tutaj pliki do przesłania (maksymalnie 20)',
            init: function () {

                var myDropzone = this;

                // Update selector to match your button
                $("#sendButton").click(function (e) {
                    e.preventDefault();
                    myDropzone.processQueue();
                });

                $("#cancelButton").click(function () {
                    myDropzone.removeAllFiles();
                });

                this.on('sending', function (file, xhr, formData) {
                    // Append all form inputs to the formData Dropzone will POST
                    var data = $('#dropzoneSendFiles').serializeArray();
                    $.each(data, function (key, el) {
                        formData.append(el.name, el.value);
                    });
                });

                this.on("queuecomplete", function () {
                    location.reload();
                });

                this.on("processing", function () {
                    this.options.autoProcessQueue = true;
                });
            }
        }
    </script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edycja sprawozdania') }}</div>
                    <div class="card-body">
                        {{ Breadcrumbs::render('clubReport.edit', $club, $report) }}
                        <form method="POST" action="{{ route('clubReport.update',[$club,$report]) }}">
                            @method('PATCH')
                            @csrf
                            <div class="container mt-4 mb-4">
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12 col-lg-8">
                                        <div class="form-group">
                                            <textarea id="editor" type="text"
                                                      class="form-control @error('description') is-invalid @enderror"
                                                      name="description" autocomplete="off"
                                                      autofocus>{{ $report->description }}</textarea>

                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror

                                        </div>
                                        <button type="submit" class="btn btn-success">
                                            {{ __('Zatwierdź zmiany') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <a href="{{ route('clubReport.generatePDF', [$club, $report])}}"
                           class="btn btn-primary">Wygeneruj sprawozdanie (PDF)</a>
                        <a href="{{ route('clubReport.generateDoc', [$club, $report])}}"
                           class="btn btn-primary">Wygeneruj sprawozdanie (DOC)</a>
                        @if($club->getLoggedUserRoleName() == 'opiekun_koła' || $club->getLoggedUserRoleName() == 'przewodniczący_koła')
                            @if($attachments_send == FALSE)

                                <div class="card-body">
                                    <form method="POST"
                                          action="{{ route('clubReport.submitToSupervisor',[$club,$report]) }}"
                                          id="dropzoneSendFiles"
                                          class="dropzone" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="action" value="submit">
                                    </form>
                                    <button id="sendButton" type="submit" class="btn btn-success">
                                        {{ __('Prześlj do opiekuna') }}
                                    </button>
                                    <button id="cancelButton" type="submit" class="btn btn-danger">
                                        {{ __('Anuluj wysyłanie') }}
                                    </button>
                                </div>
                            @endif

                            @if($attachments_send == TRUE)
                                @if(isset($report->supervisor_approved) && $report->supervisor_approved == FALSE)
                                    <h4 class="text-danger font-weight-bold">Status: Odrzucono przez opiekuna</h4>
                                    <div>Uwagi: {{$report->remarks}}</div>
                                @elseif(isset($report->secretariat_approved) && $report->secretariat_approved == FALSE)
                                    <h4 class="text-danger font-weight-bold">Status: Odrzucono przez sekretariat</h4>
                                    <div>Uwagi: {{$report->remarks}}</div>
                                @elseif(isset($report['vice-rector_approved']) && $report['vice-rector_approved'] == FALSE)
                                    <h4 class="text-danger font-weight-bold">Status: Odrzucono przez wice-rektora</h4>
                                    <div>Uwagi: {{$report->remarks}}</div>
                                @elseif($report['vice-rector_approved'] == TRUE)
                                    <h4 class="text-success font-weight-bold">Status: Zaakceptowano przez
                                        prorektora</h4>
                                @elseif($report->secretariat_approved == TRUE)
                                    <h4 class="text-info font-weight-bold">Status: Zaakceptowano przez sekretariat</h4>
                                @elseif($report->supervisor_approved == TRUE)
                                    <h4 class="text-info font-weight-bold">Status: Zaakceptowano przez opiekuna</h4>
                                @else
                                    <h4 class="text-info font-weight-bold">Status: Przekazano do opiekuna</h4>
                                @endif

                                <div>Wysłane pliki:</div>
                                @foreach($report->attachments as $attachment)
                                    <a href="{{ route('downloadAttachment', ['path' => $attachment->name])}}">{{$attachment->original_file_name}}</a>
                                    <br>
                                @endforeach
                                <form method="POST"
                                      action="{{ route('clubReport.submitToSupervisor',[$club,$report]) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="action" value="undo">
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-secondary">
                                                {{ __('Cofnij wysyłanie') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
