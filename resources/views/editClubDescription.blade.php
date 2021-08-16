@extends('layouts.layout')

@section('content')

    <script src="https://cdn.tiny.cloud/1/l2jgkyuas2hqjvouzqo4u8u5f0vtgxfc3ycnzylyuvi6zr28/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea#editor',
            plugins: 'lists, autoresize',
            toolbar: 'bold italic strikethrough bullist numlist',
            menubar: false,
            forced_root_block : false,
        });
    </script>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edytuj opis koła/sekcji') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('club.description.update', $club) }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Opis') }}</label>

                            <div class="col-md-6">
                                <textarea id="editor" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="off">{{ $club->description }}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edytuj opis') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
