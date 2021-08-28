@extends('layouts.layout')

@section('content')

    <script src="https://cdn.tiny.cloud/1/l2jgkyuas2hqjvouzqo4u8u5f0vtgxfc3ycnzylyuvi6zr28/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea#editor',
            plugins: 'lists, autoresize',
            toolbar: 'bold italic strikethrough bullist numlist',
            menubar: false,
            forced_root_block: false,
        });
    </script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edytuj opis koła/sekcji') }}</div>
                    <div class="card-body">
                        {{ Breadcrumbs::render('club.description.edit', $club) }}
                        <form method="POST" action="{{ route('club.description.update', $club) }}">
                            @method('PATCH')
                            @csrf
                            <div class="container mt-4 mb-4">
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12 col-lg-8">
                                        <div class="form-group">
                                            <textarea id="editor" type="text"
                                                      class="form-control @error('description') is-invalid @enderror"
                                                      name="description" autocomplete="off"
                                                      autofocus>{{ $club->description }}</textarea>

                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror

                                        </div>
                                        <button type="submit" class="btn btn-success">
                                            {{ __('Edytuj opis') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
