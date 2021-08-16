@extends('layouts.layout')

@section('content')

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
                    <div class="card-header">{{ __('Dodaj przedmiot') }}</div>

                    <div class="card-body">
                        {{ Breadcrumbs::render('spendingPlan.edit', $club, $report) }}
                        <form method="POST" action="{{ route('spendingPlan.store', [$club,$report]) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Przedmiot zamówienia') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name" required autocomplete="off" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Opis przedmiotu') }}</label>

                                <div class="col-md-6">
                                    <input id="description" type="text"
                                           class="form-control @error('description') is-invalid @enderror"
                                           name="description" autocomplete="off" autofocus>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Rodzaj (dostawa/usługa)') }}</label>

                                <div class="col-md-6">
                                    <input id="type" type="text"
                                           class="form-control @error('type') is-invalid @enderror"
                                           name="type" autocomplete="off" autofocus>

                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Ilość') }}</label>

                                <div class="col-md-6">
                                    <input id="quantity" type="text"
                                           class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                           autocomplete="off" autofocus>

                                    @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gross"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Szacunkowa kwota brutto') }}</label>

                                <div class="col-md-6">
                                    <input id="gross" type="text"
                                           class="form-control @error('gross') is-invalid @enderror"
                                           name="gross" autocomplete="off" autofocus>

                                    @error('gross')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="term"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Szacowany miesiąc rozpoczęcia i zakończenia realizacji') }}</label>

                                <div class="col-md-6">
                                    <input id="term" type="text"
                                           class="form-control @error('term') is-invalid @enderror"
                                           name="term" autocomplete="off" autofocus>

                                    @error('term')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Dodaj przedmiot') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div>Zapisane przedmioty:</div>
                        <div class="accordion" id="accordion">
                            @foreach($report->orders as $order)
                                <div class="card">
                                    <div class="card-header" id="heading{{$order->id}}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                    data-target="#collapse{{$order->id}}" aria-expanded="false"
                                                    aria-controls="collapse{{$order->id}}">
                                                {{$order->name}}
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapse{{$order->id}}" class="collapse"
                                         aria-labelledby="heading{{$order->id}}" data-parent="#accordion">
                                        <div class="card-body">
                                            <form method="POST"
                                                  action="{{ route('spendingPlan.update', [$club, $report, $order]) }}">
                                                @method('PATCH')
                                                @csrf

                                                <div class="form-group row">
                                                    <label for="name"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Przedmiot zamówienia') }}</label>

                                                    <div class="col-md-6">
                                                        <input value="{{$order->name}}" id="name" type="text"
                                                               class="form-control @error('name') is-invalid @enderror"
                                                               name="name" required autocomplete="off" autofocus>

                                                        @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="description"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Opis przedmiotu') }}</label>

                                                    <div class="col-md-6">
                                                        <input value="{{$order->description}}" id="description"
                                                               type="text"
                                                               class="form-control @error('description') is-invalid @enderror"
                                                               name="description" autocomplete="off" autofocus>

                                                        @error('description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="type"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Rodzaj (dostawa/usługa)') }}</label>

                                                    <div class="col-md-6">
                                                        <input value="{{$order->type}}" id="type" type="text"
                                                               class="form-control @error('type') is-invalid @enderror"
                                                               name="type" autocomplete="off" autofocus>

                                                        @error('type')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="quantity"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Ilość') }}</label>

                                                    <div class="col-md-6">
                                                        <input value="{{$order->quantity}}" id="quantity" type="text"
                                                               class="form-control @error('quantity') is-invalid @enderror"
                                                               name="quantity"
                                                               autocomplete="off" autofocus>

                                                        @error('quantity')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="gross"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Szacunkowa kwota brutto') }}</label>

                                                    <div class="col-md-6">
                                                        <input value="{{$order->gross}}" id="gross" type="text"
                                                               class="form-control @error('gross') is-invalid @enderror"
                                                               name="gross" autocomplete="off" autofocus>

                                                        @error('gross')
                                                        <span class="invalid-feedback" role="alert">
                                                             <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="term"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Szacowany miesiąc rozpoczęcia i zakończenia realizacji') }}</label>

                                                    <div class="col-md-6">
                                                        <input value="{{$order->term}}" id="term" type="text"
                                                               class="form-control @error('term') is-invalid @enderror"
                                                               name="term" autocomplete="off" autofocus>

                                                        @error('term')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-0">
                                                    <div class="col-md-6 offset-md-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('Edytuj') }}
                                                        </button>
                                                        <button form="deleteForm" onclick="return confirm('Jesteś pewien?')"
                                                                class="btn btn-danger" type="submit">{{ __('Usuń') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <form id="deleteForm" action="{{ route('spendingPlan.destroy', [$club, $report, $order])}}"
                                                  method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>

                        <a href="{{ route('spendingPlan.generatePDF', [$club, $report])}}" class="btn btn-primary">Wygeneruj
                            plan wydatków (PDF)</a>
                        <a href="{{ route('spendingPlan.generateExcel', [$club, $report])}}"
                           class="btn btn-primary">Wygeneruj
                            plan wydatków (Excel)</a>

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
