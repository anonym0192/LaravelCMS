@extends('adminlte::page')


@section('title', 'Editar Usuário')
    

@section('content_header')
    <h1>Atualizar dados do Usuário</h1>
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
    <div class="card">
        <form method="post" action="{{route('users.update', $user->id)}}" style="max-width: 700px" >
            @method('put')
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-4 col-form-label " for="name">Nome Completo</label>
                    <input type="text" class="form-control col-8 @error('name') is-invalid @enderror" id="name" name="name" required value="{{$user->name}}">
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label " for="email">E-mail</label>
                    <input type="email" class="form-control col-8 @error('email') is-invalid @enderror " id="email" name="email" required value="{{$user->email}}">
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label " for="password">Nova Senha</label>
                    <input type="password" class="form-control col-8 @error('password') is-invalid @enderror" id="password" name="password" >
                </div>
                <div class="form-group row">
                    <label class="col-4 col-form-label " for="password_confirmation">Confirmar Nova Senha</label>
                    <input type="password" class="form-control col-8" id="password_confirmation" name="password_confirmation" >
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>      
        </form>
    </div>
@endsection