@extends('layouts.layout')

@section('content')
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dodaj przedmiot') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('spendingPlan.store', [$club,$report]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Przedmiot zamówienia') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
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
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Rodzaj') }}</label>

                            <div class="col-md-6">
                                <input id="type" type="text" class="form-control @error('type') is-invalid @enderror"
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
                                <input id="gross" type="text" class="form-control @error('gross') is-invalid @enderror"
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
                                <input id="term" type="text" class="form-control @error('term') is-invalid @enderror"
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
                                    {{ __('Dodaj przedmiot') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <a href="{{ route('spendingPlan.generate', [$club, $report])}}" class="btn btn-primary">Wygeneruj
                        plan wydatków</a>

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

                    <div>Wysłane przedmioty:</div>
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
                                                       class="col-md-4 col-form-label text-md-right">{{ __('Rodzaj') }}</label>

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

                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Edytuj') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('spendingPlan.destroy', [$club, $report, $order])}}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Jesteś pewien?')"
                                                    class="btn btn-danger" type="submit">Usuń
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
