@extends('layouts.layout')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Archiwum') }}</div>
                    <div class="card-body">
                        {{ Breadcrumbs::render('clubActionPlan.edit', $club, $report) }}

                        {!!$report->description!!}

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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
