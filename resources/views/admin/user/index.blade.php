@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
<h1>Página de Usuários  <a href="{{route('users.create')}}" class="btn btn-sm btn-primary" >Novo Usuário</a></h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>
                            Ações
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <a href="{{route('users.edit', ['user' => $user->id])}}" class="btn btn-info" >
                                        Editar
                                </a>
                                <form method="POST" class="d-inline" action="{{route('users.destroy', $user->id)}}" onsubmit="return confirm('Tem certeza que deseja exluir o usuário ?')">
                                    @method('DELETE')
                                    @csrf
                                    <button @if($loggedId == $user->id) disabled @endif type="submit" class="btn btn-danger" >
                                            Excluir
                                    </button>
                                </form>  
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{$users->links('pagination::bootstrap-4')}}

@endsection