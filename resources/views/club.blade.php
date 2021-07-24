@extends('layouts.layout')

@section('content')

    <script>
        Dropzone.options.dropzoneSendFiles = {
            autoProcessQueue: false,
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
        {{$club->name}}<br>
        <a href="{{route('listClubMembers.index', ['club' => $club])}}">Lista członków koła</a><br>
        @if($club->getLoggedUserRoleName() == 'opiekun_koła')
            <a href="{{route('clubReport.showReportsForApproval', ['club' => $club])}}">Pisma czekające na
                akceptację</a>
        @endif

        <br><a href="{{ route('clubReport.edit',[$club, $report])}}" class="btn btn-primary">Edytuj
            sprawozdanie</a>

        <br><a href="{{ route('clubActionPlan.edit',[$club, $action_plan])}}" class="btn btn-primary">Edytuj
            plan działania</a>

        <br><a href="{{ route('spendingPlan.edit',[$club, $spending_plan])}}" class="btn btn-primary">Edytuj plan
            wydatków</a>

        @if($club->getLoggedUserRoleName() == 'opiekun_koła' || $club->getLoggedUserRoleName() == 'opiekun_koła' || $club->getLoggedUserRoleName() == 'przewodniczący_koła')
            <br><a href="{{ route('meetings.index', $club)}}" class="btn btn-primary">Dziennik spotkań</a>
        @endif




        <div class="card-body">
            <form method="POST" action="{{ route('clubMainPageFile.store', $club) }}" id="dropzoneSendFiles"
                  class="dropzone" enctype="multipart/form-data">
                @csrf
            </form>
            <button id="sendButton" type="submit" class="btn btn-primary">
                {{ __('Dodaj pliki') }}
            </button>
            <button id="cancelButton" type="submit" class="btn btn-primary">
                {{ __('Anuluj wysyłanie') }}
            </button>
        </div>


        <div class="photo-gallery">
            <div class="container">
                <div class="row photos">
                    @foreach($imageFiles as $imageFile)
                        <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="{{ url('/storage/' . $imageFile->name) }}"
                                                                        data-lightbox="photos"><img class="img-fluid"
                                                                                                    src="{{ asset('storage/' . $imageFile->name) }}"></a>
                            <form action="{{ route('clubMainPageFile.destroyFile', [$club, $imageFile])}}"
                                  method="post">
                                @csrf
                                @method('DELETE')
                                @if (Auth::check())
                                    @if($imageFile->users_id == Auth::user()->id || Auth::user()->isAdministrator()
|| $club->getLoggedUserRoleName() == 'opiekun_koła' || $club->getLoggedUserRoleName() == 'przewodniczący_koła')
                                        <button onclick="return confirm('Jesteś pewien?')" class="remove-image"
                                                style="display: inline;" type="submit">&#215;
                                        </button>
                                    @endif
                                @endif
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        @foreach($noImageFiles as $noImageFile)
            <div class="row">
                <div class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                        <path
                            d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"/>
                        <path
                            d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                    </svg>
                    <a href="{{ route('downloadFile', ['path' => $noImageFile->name])}}">{{$noImageFile->original_file_name}}</a>
                </div>
                @if (Auth::check())
                    @if($imageFile->users_id == Auth::user()->id || Auth::user()->isAdministrator()
    || $club->getLoggedUserRoleName() == 'opiekun_koła' || $club->getLoggedUserRoleName() == 'przewodniczący_koła')
                        <div>
                            <form action="{{ route('clubMainPageFile.destroyFile', [$club, $noImageFile])}}"
                                  method="post">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Jesteś pewien?')" class="btn btn-danger col-xs-3"
                                        type="submit">Usuń
                                </button>
                            </form>
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
@endsection

