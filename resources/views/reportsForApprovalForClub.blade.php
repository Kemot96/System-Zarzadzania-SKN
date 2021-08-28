@extends('layouts.layout')

@section('content')

    <script src="{{ asset('/js/reportsModal.js') }} "></script>
    <div class="container">
    {{ Breadcrumbs::render('clubReport.showReportsForApproval', $club) }}

    <!-- Page Content -->
    <div id="content">

        <table class="table table-striped">
            <thead>
            <tr>
                <td>Osoba składające sprawozdanie</td>
                <td>Typ sprawozdania</td>
                <td>Załączniki</td>
                <td colspan="2">Akcje</td>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{$report->user->name}}</td>
                    <td>{{$report->type->name}}</td>
                    <td>
                        @foreach($report->attachments as $attachment)
                            <a href="{{ route('downloadAttachment', ['path' => $attachment->name])}}">{{$attachment->original_file_name}}</a>
                        @endforeach
                    </td>
                    @if(!isset($report->supervisor_approved))
                        <td>
                            <form action="{{ route('clubReport.ReportActionAsSupervisor', [$club])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="accept">
                                <input type="hidden" name="modal-input-report-id" id="modal-input-report-id1" value="{{$report->id}}">
                                <button class="btn btn-success" type="submit">Zatwierdź</button>
                            </form>
                        </td>
                        <td>
                            <button id="edit-item" data-toggle="modal" data-item-id="{{$report->id}}" class="btn btn-danger" type="button">Odrzuć</button>
                        </td>
                    @elseif($report->supervisor_approved == TRUE)
                        <td>
                            Zaakceptowano
                        </td>
                        <td>
                            @if($report['secretariat_approved'] == TRUE)
                                Zaakceptowano przez sekretariat
                            @else
                                <form action="{{ route('clubReport.ReportActionAsSupervisor', [$club])}}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="undo">
                                    <input type="hidden" name="modal-input-report-id" id="modal-input-report-id2" value="{{$report->id}}">
                                    <button class="btn btn-danger" type="submit">Cofnij akcję</button>
                                </form>
                            @endif
                        </td>
                    @elseif($report->supervisor_approved == FALSE)
                        <td>
                            Odrzucono
                        </td>
                        <td>
                            <form action="{{ route('clubReport.ReportActionAsSupervisor', [$club])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="undo">
                                <input type="hidden" name="modal-input-report-id" id="modal-input-report-id3" value="{{$report->id}}">
                                <button class="btn btn-danger" type="submit">Cofnij akcję</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Attachment Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('clubReport.ReportActionAsSupervisor', [$club])}}" method="post">
                    <div class="modal-body" id="attachment-body-content">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" value="dismiss">
                        <input type="hidden" name="modal-input-report-id" id="modal-input-report-id4">

                        <div class="card text-white bg-dark mb-0">
                            <div class="card-body">
                                <!-- remarks -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-remarks">Uwagi</label>
                                    <textarea type="text" name="modal-input-remarks" class="form-control" id="modal-input-remarks"></textarea>
                                </div>
                                <!-- /remarks -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Wyślij</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Attachment Modal -->
    </div>
@endsection

