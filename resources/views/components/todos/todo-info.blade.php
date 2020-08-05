<strong>
    <span class="badge badge-dark">
        #{{ $info->id }}
    </span>
</strong>
<small>
    Créée {{ $info->created_at->from() }} par

    {{ Auth::user()->id == $info->user->id ? 'moi' : $info->user->name }}

    @if ($info->todoAffectedTo && $info->todoAffectedTo->id == Auth::user()->id)
    affectée à moi
    @elseif ($info->todoAffectedTo)
    {{ $info->todoAffectedTo ? ', affectée à ' . $info->todoAffectedTo->name : ''}}
    @endif
    {{--  display affected by someone or by user himself  --}}
    @if ($info->todoAffectedTo && $info->todoAffectedBy && $info->todoAffectedBy->id == Auth::user()->id)
    par moi-même :D
    @elseif ($info->todoAffectedTo && $info->todoAffectedBy && $info->todoAffectedBy->id != Auth::user()->id)
    par {{ $info->todoAffectedBy->name }}
    @endif
</small>

@if($info->done)
<small>
    <p>
        Terminée
        {{ $info->updated_at->from() }} - Terminée en
        {{ $info->updated_at->diffForHumans($info->created_at, 1) }}
    </p>
</small>
@endif
