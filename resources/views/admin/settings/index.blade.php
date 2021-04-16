
@extends('adminlte::page')

@section('title', 'Configurações do Site')
    
@section('content_header')
    <h1>Configurações</h1>
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
        <form action="{{route('settings.save')}}" method="post" style="max-width: 700px;">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-4 col-form-label " for="title">Título</label>
                    <input type="text" class="form-control col-8 @error('title') is-invalid @enderror" id="title" name="title" value="{{$settings['title']}}" required >
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label " for="subtitle">Subtítulo</label>
                <input type="text" class="form-control col-8 @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{$settings['subtitle']}}" >
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label" for="bgColor">Cor de Fundo</label>
                    <input type="color" id="bgColor" name="bgColor" value="{{$settings['bgColor']}}" >
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label" for="txtColor">Cor de Texto</label>
                    <input type="color" id="txtColor" name="txtColor" value="{{$settings['txtColor']}}" >
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
@endsection