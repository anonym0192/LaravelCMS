@extends('adminlte::page')


@section('title', 'Nova Página')
    

@section('content_header')
    <h1>Criar nova Página</h1>
@endsection

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            <h4>Ocorreu um erro.</h4>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('warning'))
    <div class="alert alert-success">
        {{session('warning')}}
    </div>
    @endif
    <div class="card">
        <form method="post" action="{{route('pages.store')}}" >
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-4 col-form-label " for="title">Título</label>
                    <input type="text" class="form-control col-8 @error('title') is-invalid @enderror" id="title" name="title" required value="{{old('title')}}">
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label " for="pagebody">Corpo da Página</label>
                    <textarea class="col-8" id="pagebody" name="body">
                        {{old('body')}}
                    </textarea>
                </div>
                
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>      
        </form>
    </div>

    <script src='https://cdn.tiny.cloud/1/22avwix94rfxqwfhdpw3xpidq0v2kaa1dztpja2avs72gx25/tinymce/5/tinymce.min.js' referrerpolicy="origin">
    </script>
    <script>
      tinymce.init({
        selector: '#pagebody',
        toolbar: 'undo redo | styleselect | bold italic backcolor| link image | alignleft aligncenter alignright alignjustify',
        plugins: ['link', 'table', 'image', 'autoresize' ,'lists'],
        height: '354px',
        width: '100%',
        menubar: false,
        content_css : 'writer',
        plugins: 'image imagetools',
        images_upload_url: '{{route('imageupload')}}',
        images_upload_credentials: true,
        convert_urls: false
      });
    </script>
@endsection