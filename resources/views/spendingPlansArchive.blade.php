@extends('layouts.layout')

@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dodaj przedmiot') }}</div>

                    <div class="card-body">
                        {{ Breadcrumbs::render('spendingPlan.edit', $club, $report) }}

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
                                                               name="name" required autocomplete="off" disabled>

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
                                                               name="description" autocomplete="off" disabled>

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
                                                               name="type" autocomplete="off" disabled>

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
                                                               autocomplete="off" disabled>

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
                                                               name="gross" autocomplete="off" disabled>

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
                                                               name="term" autocomplete="off" disabled>

                                                        @error('term')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
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


                        @if($club->getLoggedUserRoleName() == 'opiekun_koła' || $club->getLoggedUserRoleName() == 'przewodniczący_koła')


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
                            @endif
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
