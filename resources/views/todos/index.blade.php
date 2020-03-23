@extends('layouts.app')

@section('content')
<a name="" id="" class="btn btn-primary my-4" href="{{ route('todos.create') }}" role="button">Ajouter une todo</a>
{{-- Done's todos link --}}
@if (Route::currentRouteName() == 'todos.index')
<a name="" id="" class="btn btn-warning my-4" href="{{ route('todos.undone') }}" role="button">Voir les todos
    ouvertes</a>
<a name="" id="" class="btn btn-success my-4" href="{{ route('todos.done') }}" role="button">Voir les todos
    terminées</a>
{{-- All todos --}}
@elseif (Route::currentRouteName() == 'todos.done')
<a name="" id="" class="btn btn-dark my-4" href="{{ route('todos.index') }}" role="button">Voir toutes les todos</a>
<a name="" id="" class="btn btn-warning my-4" href="{{ route('todos.undone') }}" role="button">Voir les todos
    ouvertes</a>
{{-- Undone's todos link --}}
@elseif (Route::currentRouteName() == 'todos.undone')
<a name="" id="" class="btn btn-dark my-4" href="{{ route('todos.index') }}" role="button">Voir toutes les todos</a>
<a name="" id="" class="btn btn-success my-4" href="{{ route('todos.done') }}" role="button">Voir les todos
    terminées</a>
@endif
{{-- All todos title --}}
@if (Route::currentRouteName() == 'todos.index')
<h1>Toutes les todos</h1>
{{-- Undone's todos title --}}
@elseif (Route::currentRouteName() == 'todos.undone')
<h1>Toutes les todos ouvertes</h1>
@else
{{-- Done's todos title --}}
<h1>Todos terminées</h1>
@endif
@foreach ($datas as $data)
<div class="alert alert-{{ $data->done ? 'success' : 'warning' }}" role="alert">
    <div class="row">
        <div class="col-sm">
            <p class="my-0"><strong>
                    <span class="badge badge-dark">
                        #{{ $data->id }}
                    </span>
                </strong><small> Créée {{ $data->created_at->from() }}
                    @if($data->done)
                    - Terminée
                    {{ $data->updated_at->from() }} - Terminée en
                    {{ $data->updated_at->diffForHumans($data->created_at, 1) }}
                    @endif</small></p>

            <details>
                <summary><strong>{{ $data->name}}</strong> @if($data->done)<span
                        class="badge badge-success">done</span>@endif
                </summary>

                <p>{{ $data->description }}</p>
            </details>



        </div>
        <div class="form-inline justify-content-end my-1 p-0 col-sm" aria-label="Basic example">
            @if($data->done == 0)
            <form action="{{ route('todos.makedone', $data->id) }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success mx-1 my-0">Done</button>
            </form>
            @endif
            <a name="" id="" class="btn btn-info mx-1 my-0" href="{{ route('todos.edit', $data->id) }}"
                role="button">Editer</a>
            <form action="{{ route('todos.destroy', $data->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mx-1 my-0" label="remove">Effacer</button>
            </form>
        </div>
    </div>
</div>
@endforeach


{{ $datas->onEachSide(2)->links() }}
@endsection
