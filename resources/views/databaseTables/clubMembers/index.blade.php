@extends('layouts.adminLayout')

@section('content')

      <!-- Page Content -->
      <div id="content">

          <table class="table table-striped">
              <thead>
              <tr>
                  <td>Użytkownik</td>
                  <td>Rola</td>
                  <td>Klub</td>
                  <td>Rok akademicki</td>
                  <td colspan="2">Akcje</td>
              </tr>
              </thead>
              <tbody>
              @foreach($club_members as $club_member)
                  <tr>
                      <td>{{$club_member->user->name}}</td>
                      <td>{{$club_member->role->name}}</td>
                      <td>{{$club_member->club->name}}</td>
                      <td>{{$club_member->academicYear->name}}</td>
                      <td><a href="{{ route('clubMembers.edit',$club_member->id)}}" class="btn btn-primary">Edytuj</a></td>
                      <td>
                          <form action="{{ route('clubMembers.destroy', $club_member->id)}}" method="post">
                              @csrf
                              @method('DELETE')
                              <button onclick="return confirm('Jesteś pewien?')" class="btn btn-danger" type="submit">Usuń</button>
                          </form>
                      </td>
                  </tr>
              @endforeach
              </tbody>
          </table>
          {{ $club_members->links() }}
          <a href="{{ route('clubMembers.create')}}" class="btn btn-success">Dodaj członka klubu</a>
          <a href="{{ url('/') }}" class="btn btn-success">Powrót na stronę główną</a>

      </div>
  @endsection

