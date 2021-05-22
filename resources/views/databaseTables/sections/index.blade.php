@extends('layouts.adminLayout')

@section('content')

      <!-- Page Content -->
      <div id="content">

          <table class="table table-striped">
              <thead>
              <tr>
                  <td>Nazwa</td>
                  <td>Klub</td>
                  <td colspan="2">Akcje</td>
              </tr>
              </thead>
              <tbody>
              @foreach($sections as $section)
                  <tr>
                      <td>{{$section->name}}</td>
                      <td>{{$section->club->name}}</td>
                      <td><a href="{{ route('sections.edit',$section->id)}}" class="btn btn-primary">Edytuj</a></td>
                      <td>
                          <form action="{{ route('sections.destroy', $section->id)}}" method="post">
                              @csrf
                              @method('DELETE')
                              <button onclick="return confirm('Jesteś pewien?')" class="btn btn-danger" type="submit">Usuń</button>
                          </form>
                      </td>
                  </tr>
              @endforeach
              </tbody>
          </table>
          {{ $sections->links() }}
          <a href="{{ route('sections.create')}}" class="btn btn-success">Dodaj sekcję</a>
          <a href="{{ url('/') }}" class="btn btn-success">Powrót na stronę główną</a>

      </div>
  @endsection

