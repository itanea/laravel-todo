@php
//dd($affectedto);
@endphp

@extends('layouts.app')

@section('content')

{{--  Display filters buttons bar  --}}
<x-todos.filters />

{{-- All todos title --}}
@if (Route::currentRouteName() == 'todos.index')
<h1>Toutes les todos ({{ $datas->total() }})</h1>
{{-- Undone's todos title --}}
@elseif (Route::currentRouteName() == 'todos.undone')
<h1>Toutes les todos ouvertes ({{ $datas->total() }})</h1>
@elseif (Route::currentRouteName() == 'todos.createdbyme')
<h1>Les todos créées par moi ({{ $datas->total() }})</h1>
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
