{{$club->name}}
@if($club->getLoggedUserRoleName() == 'opiekun_koła')
    <a href="{{route('clubMembers.index2', ['club' => $club])}}">Lista członków koła</a>
@endif
@if($club->getLoggedUserRoleName() == 'członek_koła' || 'przewodniczący_koła')

    <br><a href="{{ route('clubEditReport.edit',$club->id)}}" class="btn btn-primary">Edytuj sprawozdanie</a>

    <div class="card-body">
        <form method="POST" action="{{ route('clubMainPageFile.store', $club) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Dodaj plik') }}</label>
                <div class="col-md-6">
                    <input id="file" type="file" class="form-control-file @error('description') is-invalid @enderror" name="file">

                    @error('file')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Dodaj plik') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endif
@foreach($files as $file)
    {{$file->name}}<br>
@endforeach

