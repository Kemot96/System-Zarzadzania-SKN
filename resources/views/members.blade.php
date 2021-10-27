@extends('layouts.layout')

@section('content')
    <script src="{{ asset('/js/removeMemberRequestModal.js') }} "></script>
    <div class="container">
    {{ Breadcrumbs::render('listClubMembers.index', $club) }}
    @if($club->getLoggedUserRoleName() == 'opiekun_koła')
        <!-- Page Content -->
        <div id="content">
            <div class="table-responsive">
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
                    @if($club_member->roles_id != $inactive_role_id)
                    <tr>
                        <td>{{$club_member->user->name}}</td>
                        <td>{{$club_member->role->name}}</td>
                        <td>
                                <a href="{{ route('listClubMembers.edit', [$club, $club_member])}}" class="btn btn-primary">Edytuj rolę</a>
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
                    @endif
                @endforeach
                </tbody>
            </table>
            </div>
            <div>Nieaktywni członkowie:</div>
            <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Użytkownik</td>
                    <td colspan="2">Akcje</td>
                </tr>
                </thead>
                <tbody>
                @foreach($club_members as $club_member)
                    @if($club_member->roles_id == $inactive_role_id)
                        <tr>
                            <td>{{$club_member->user->name}}</td>
                            <td>
                                    <form action="{{ route('listClubMembers.confirm', [$club, $club_member])}}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-success" type="submit">Zatwierdź</button>
                                    </form>
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
                    @endif
                @endforeach
                </tbody>
            </table>
            </div>

            <div>Członkowie z wnioskiem o skreślenie:</div>
            <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>Użytkownik</td>
                    <td>Rola</td>
                    <td>Powód</td>
                    <td colspan="2">Akcje</td>
                </tr>
                </thead>
                <tbody>
                @foreach($club_members_with_removal_request as $club_member_with_removal_request)
                    @if($club_member->roles_id != $inactive_role_id)
                        <tr>
                            <td>{{$club_member_with_removal_request->user->name}}</td>
                            <td>{{$club_member_with_removal_request->role->name}}</td>
                            <td>{{$club_member_with_removal_request->reason_to_removal}}</td>
                            <td>
                                <form action="{{ route('listClubMembers.removeRequest', [$club])}}"
                                      method="post">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="action" value="discardRemoveRequest">
                                    <input type="hidden" name="clubMember" value="{{$club_member_with_removal_request->id}}">
                                    <button class="btn btn-primary" type="submit">Odrzuć wniosek</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('listClubMembers.destroy', [$club, $club_member_with_removal_request])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Jesteś pewien?')" class="btn btn-danger" type="submit">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
    @elseif($club->getLoggedUserRoleName() == 'przewodniczący_koła')
        <!-- Page Content -->
        <div id="content">
            <div class="table-responsive">
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
                    @if($club_member->roles_id != $inactive_role_id)
                    <tr>
                        <td>{{$club_member->user->name}}</td>
                        <td>{{$club_member->role->name}}</td>
                        <td>
                            @if($club_member->removal_request != TRUE && $club_member->user->id != Auth::id() && $club_member->roles_id != $supervisor_role_id)
                                <button id="edit-item" data-toggle="modal" data-item-id="{{$club_member->id}}" class="btn btn-danger" type="button">Wniosek o skreślenie z listy członków</button>
                            @elseif($club_member->user->id != Auth::id() && $club_member->roles_id != $supervisor_role_id)
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
                    @endif
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
    @elseif($club->getLoggedUserRoleName() == 'członek_koła')
        <!-- Page Content -->
            <div id="content">
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>Użytkownik</td>
                        <td>Rola</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($club_members as $club_member)
                        @if($club_member->roles_id != $inactive_role_id)
                        <tr>
                            <td>{{$club_member->user->name}}</td>
                            <td>{{$club_member->role->name}}</td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                </div>
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

