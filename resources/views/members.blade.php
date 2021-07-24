@extends('layouts.layout')

@section('content')
    <script src="{{ asset('/js/removeMemberRequestModal.js') }} "></script>
    <div class="container">
    @if($club->getLoggedUserRoleName() == 'opiekun_koła')
        <!-- Page Content -->
        <div id="content">

            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Użytkownik</td>
                    <td>Rola</td>
                    <td colspan="2">Akcje</td>
                </tr>
                </thead>
                <tbody>
                @foreach($club_members as $club_member)
                    <tr>
                        <td>{{$club_member->user->name}}</td>
                        <td>{{$club_member->role->name}}</td>
                        <td>
                            @if($club_member->role->name == 'nieaktywny')
                                <form action="{{ route('listClubMembers.confirm', [$club, $club_member])}}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success" type="submit">Zatwierdź</button>
                                </form>
                            @elseif($club_member->user->id != Auth::id())
                                <a href="{{ route('listClubMembers.edit', [$club, $club_member])}}" class="btn btn-primary">Edytuj rolę</a>
                            @endif
                        </td>
                        <td>
                            @if($club_member->user->id != Auth::id())
                                <form action="{{ route('listClubMembers.destroy', [$club, $club_member])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Jesteś pewien?')" class="btn btn-danger" type="submit">Usuń</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>Członkowie z wnioskiem o skreślenie:</div>
            @foreach($club_members_with_removal_request as $club_member_with_removal_request)
            <div>{{$club_member_with_removal_request->user->name}}</div>
                <div><form action="{{ route('listClubMembers.destroy', [$club, $club_member_with_removal_request])}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Jesteś pewien?')" class="btn btn-danger" type="submit">Usuń</button>
                </form></div>
                <div>
                    <form action="{{ route('listClubMembers.removeRequest', [$club])}}"
                          method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" value="discardRemoveRequest">
                        <input type="hidden" name="clubMember" value="{{$club_member_with_removal_request->id}}">
                        <button class="btn btn-primary" type="submit">Odrzuć wniosek</button>
                    </form>
                </div>
            @endforeach
            <a href="{{ url('/') }}" class="btn btn-success">Powrót na stronę główną</a>
        </div>
    @elseif($club->getLoggedUserRoleName() == 'przewodniczący_koła')
        <!-- Page Content -->
        <div id="content">

            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Użytkownik</td>
                    <td>Rola</td>
                    <td>Akcje</td>
                </tr>
                </thead>
                <tbody>
                @foreach($club_members as $club_member)
                    <tr>
                        <td>{{$club_member->user->name}}</td>
                        <td>{{$club_member->role->name}}</td>
                        <td>
                            @if($club_member->removal_request != TRUE && $club_member->user->id != Auth::id() && $club_member->roles_id != '1')
                                <button id="edit-item" data-toggle="modal" data-item-id="{{$club_member->id}}" class="btn btn-danger" type="button">Wniosek o skreślenie z listy członków</button>
                            @elseif($club_member->user->id != Auth::id() && $club_member->roles_id != '1')
                                <form action="{{ route('listClubMembers.removeRequest', [$club])}}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="undoRemoveRequest">
                                    <input type="hidden" name="clubMember" value={{$club_member->id}}>
                                    <button class="btn btn-primary" type="submit">Cofnij wysyłanie wniosku o skreślenie</button>
                                </form>

                              @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a href="{{ url('/') }}" class="btn btn-success">Powrót na stronę główną</a>
        </div>
    @elseif($club->getLoggedUserRoleName() == 'członek_koła')
        <!-- Page Content -->
            <div id="content">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>Użytkownik</td>
                        <td>Rola</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($club_members as $club_member)
                        <tr>
                            <td>{{$club_member->user->name}}</td>
                            <td>{{$club_member->role->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <a href="{{ url('/') }}" class="btn btn-success">Powrót na stronę główną</a>
            </div>
    @endif

    <!-- Attachment Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('listClubMembers.removeRequest', [$club])}}" method="post">
                    <div class="modal-body" id="attachment-body-content">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" value="removeRequest">
                        <input type="hidden" name="modal-input-club-member-id" id="modal-input-club-member-id">

                        <div class="card text-white bg-dark mb-0">
                            <div class="card-header">
                                <h2 class="m-0">Edit</h2>
                            </div>
                            <div class="card-body">
                                <!-- reason -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-reason">Powód</label>
                                    <input type="text" name="modal-input-reason" class="form-control" id="modal-input-reason">
                                </div>
                                <!-- /reason -->
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

