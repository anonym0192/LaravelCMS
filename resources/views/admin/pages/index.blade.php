@extends('adminlte::page')

@section('title', 'Páginas do Site')

@section('content_header')
<h1>Páginas do Site <a class="btn btn-primary" href="{{route('pages.create')}}">Criar Nova</a> </h1>
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Título</th>
                    <th>
                        Ações
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td>{{$page->id}}</td>
                        <td>{{$page->title}}</td>
                        <td>
                            <a href="{{route('pages.edit', ['page' => $page->id])}}" class="btn btn-info" >
                                    Editar
                            </a>
                            <form method="POST" class="d-inline" action="{{route('pages.destroy', $page->id)}}" onsubmit="return confirm('Tem certeza que deseja exluir a página ?')">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger" >
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

{{$pages->links('pagination::bootstrap-4')}}
    
@endsection