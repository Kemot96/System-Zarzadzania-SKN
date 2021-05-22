@extends('layouts.adminLayout')

@section('content')

      <!-- Page Content -->
      <div id="content">

          <table class="table table-striped">
              <thead>
              <tr>
                  <td>Nazwa</td>
                  <td>Ikona</td>
                  <td colspan="2">Akcje</td>
              </tr>
              </thead>
              <tbody>
              @foreach($clubs as $club)
                  <tr>
                      <td>{{$club->name}}</td>
                      <td><img src="{{ asset('storage/' . $club->icon) }}"
                               alt=""
                               style=""
                               width="150"
                          ></td>
                      <td><a href="{{ route('clubs.edit',$club->id)}}" class="btn btn-primary">Edytuj</a></td>
                      <td>
                          <form action="{{ route('clubs.destroy', $club->id)}}" method="post">
                              @csrf
                              @method('DELETE')
                              <button onclick="return confirm('Jesteś pewien?')" class="btn btn-danger" type="submit">Usuń</button>
                          </form>
                      </td>
                  </tr>
              @endforeach
              </tbody>
          </table>
          {{ $clubs->links() }}
          <a href="{{ route('clubs.create')}}" class="btn btn-success">Dodaj klub</a>
          <a href="{{ url('/') }}" class="btn btn-success">Powrót na stronę główną</a>

      </div>
  @endsection

