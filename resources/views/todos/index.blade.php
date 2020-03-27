@php
//dd($affectedto);
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs">
            <a name="" id="" class="btn btn-primary m-2" href="{{ route('todos.create') }}" role="button">Ajouter une
                todo</a>
        </div>

        {{-- Done's todos link --}}
        <div class="col-xs">
            @if (Route::currentRouteName() == 'todos.index')
            <a name="" id="" class="btn btn-warning m-2" href="{{ route('todos.undone') }}" role="button">Voir les todos
                ouvertes</a>
        </div>
        <div class="col-xs">
            <a name="" id="" class="btn btn-success m-2" href="{{ route('todos.done') }}" role="button">Voir les todos
                terminées</a>
            {{-- All todos --}}
            @elseif (Route::currentRouteName() == 'todos.done')
            <a name="" id="" class="btn btn-dark m-2" href="{{ route('todos.index') }}" role="button">Voir toutes les
                todos</a>
        </div>
        <div class="col-xs">
            <a name="" id="" class="btn btn-warning m-2" href="{{ route('todos.undone') }}" role="button">Voir les todos
                ouvertes</a>
            {{-- Undone's todos link --}}
            @elseif (Route::currentRouteName() == 'todos.undone')
            <a name="" id="" class="btn btn-dark m-2" href="{{ route('todos.index') }}" role="button">Voir toutes les
                todos</a>
        </div>
        <div class="col-xs">
            <a name="" id="" class="btn btn-success m-2" href="{{ route('todos.done') }}" role="button">Voir les todos
                terminées</a>
            @endif
        </div>
    </div>

</div>
{{-- All todos title --}}
@if (Route::currentRouteName() == 'todos.index')
<h1>Toutes les todos ({{ $datas->total() }})</h1>
{{-- Undone's todos title --}}
@elseif (Route::currentRouteName() == 'todos.undone')
<h1>Toutes les todos ouvertes ({{ $datas->total() }})</h1>
@else
{{-- Done's todos title --}}
<h1>Todos terminées ({{ $datas->total() }})</h1>
@endif

@if($datas->total() > 0)

{{--  Use Todo's view component  --}}
<x-todo :datas="$datas" :users="$users" />

@else
{{ Route::currentRouteName() == 'todos.done' ? "Quoi ? vous n'avez encore rien fait!!!" : ""}}
{{ Route::currentRouteName() == 'todos.index' ? "Super, vous n'avez rien à faire !!!!" : ""}}


@endif

{{ $datas->onEachSide(2)->links() }}
@endsection
