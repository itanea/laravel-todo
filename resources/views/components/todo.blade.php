@foreach ($datas as $data)

<div class="alert alert-{{ $data->done ? 'success' : 'warning' }}" role="alert">
    <div class="row">
        <div class="col-sm">
            <p class="my-0">
                <strong>
                    <span class="badge badge-dark">
                        #{{ $data->id }}
                    </span>
                </strong>
                <small>
                    Créée {{ $data->created_at->from() }} par
                    @if($data->todoAffectedBy == null)
                    {{ Auth::user()->id == $data->user->id ? 'moi' : $data->user->name }}{{ $data->todoAffectedTo ? ', affectée à ' . $data->todoAffectedTo->name  : ''}}
                    @else
                    {{ Auth::user()->id == $data->user->id ? 'moi' : $data->user->name }}{{ $data->todoAffectedTo ? ', affectée à ' . $data->todoAffectedTo->name . ' par ' . $data->todoAffectedBy->name  : ''}}
                    @endif
                    @if($data->done)
                    - Terminée
                    {{ $data->updated_at->from() }} - Terminée en
                    {{ $data->updated_at->diffForHumans($data->created_at, 1) }}
                    @endif

                </small>
            </p>

            <details>
                <summary><strong>{{ $data->name}}</strong> @if($data->done)<span
                        class="badge badge-success">done</span>@endif
                </summary>

                <p>{{ $data->description }}</p>
            </details>


        </div>
        <div class="form-inline justify-content-end my-1 p-0 col-sm" aria-label="Basic example">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Affecter à
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach ($users as $user)
                    <a class="dropdown-item"
                        href="/todos/{{ $data->id }}/affectedto/{{ $user->id }}">{{ $user->name }}</a>
                    @endforeach
                </div>
            </div>

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
