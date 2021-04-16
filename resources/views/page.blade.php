@extends('layout')

@section('title', $page['title'])
    

@section('content')

    <section>
        <header class="major">
            <h1>{{$page['title']}}</h1>
        </header>
        <div class="content">
            {!!$page['body']!!}
        </div>
    </section>

@endsection