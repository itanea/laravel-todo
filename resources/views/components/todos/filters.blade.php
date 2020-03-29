<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs">
            <a name="" id="" class="btn btn-primary m-2" href="{{ route('todos.create') }}" role="button">Ajouter une
                todo</a>
        </div>


        {{--  START Route == todos.index  --}}
        @if (Route::currentRouteName() == 'todos.index')
        <div class="col-xs">
            <a name="" id="" class="btn btn-warning m-2" href="{{ route('todos.undone') }}" role="button">Voir les todos
                ouvertes</a>
        </div>
        <div class="col-xs">
            <a name="" id="" class="btn btn-success m-2" href="{{ route('todos.done') }}" role="button">Voir les todos
                terminées</a>
        </div>
        <div class="col-xs">
            <a name="" id="" class="btn btn-info m-2" href="{{ route('todos.createdbyme') }}" role="button">Voir les
                todos créées par moi</a>
        </div>
        @endif
        {{--  END Route == todos.index  --}}

        {{--  -------------------------------------------------------------------------------------------------  --}}

        {{--  START Route == todos.undone  --}}
        @if (Route::currentRouteName() == 'todos.undone')
        <div class="col-xs">
            <a name="" id="" class="btn btn-dark m-2" href="{{ route('todos.index') }}" role="button">Voir toutes les
                todos</a>
        </div>
        <div class="col-xs">
            <a name="" id="" class="btn btn-success m-2" href="{{ route('todos.done') }}" role="button">Voir les todos
                terminées</a>
        </div>
        <div class="col-xs">
            <a name="" id="" class="btn btn-info m-2" href="{{ route('todos.createdbyme') }}" role="button">Voir les
                todos créées par moi</a>
        </div>
        @endif
        {{--  END Route == todos.undone  --}}

        {{--  -------------------------------------------------------------------------------------------------  --}}

        {{--  START Route == todos.done  --}}
        @if (Route::currentRouteName() == 'todos.done')
        <div class="col-xs">
            <a name="" id="" class="btn btn-dark m-2" href="{{ route('todos.index') }}" role="button">Voir toutes les
                todos</a>
        </div>
        <div class="col-xs">
            <a name="" id="" class="btn btn-warning m-2" href="{{ route('todos.undone') }}" role="button">Voir les todos
                ouvertes</a>
        </div>
        <div class="col-xs">
            <a name="" id="" class="btn btn-info m-2" href="{{ route('todos.createdbyme') }}" role="button">Voir les
                todos créées par moi</a>
        </div>
        @endif
        {{--  END Route == todos.done  --}}

        {{--  -------------------------------------------------------------------------------------------------  --}}

        {{--  START Route == todos.createdbyme  --}}
        @if (Route::currentRouteName() == 'todos.createdbyme')
        <div class="col-xs">
            <a name="" id="" class="btn btn-dark m-2" href="{{ route('todos.index') }}" role="button">Voir toutes les
                todos</a>
        </div>
        <div class="col-xs">
            <a name="" id="" class="btn btn-warning m-2" href="{{ route('todos.undone') }}" role="button">Voir les todos
                ouvertes</a>
        </div>
        <div class="col-xs">
            <a name="" id="" class="btn btn-success m-2" href="{{ route('todos.done') }}" role="button">Voir les todos
                terminées</a>
        </div>
        @endif
    </div>
</div>
