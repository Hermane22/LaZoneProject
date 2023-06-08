@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row row-cols-auto justify-content-center">


            <div class="col">
                @if (Route::currentRouteName() == 'covers.index')
                    <a name="" id="" class="btn btn-danger m-2" href=" {{ route('covers.undone') }} "
                        role="button">La la liste des demandes en attente</a>
            </div>
            <div class="col">
                <a name="" id="" class="btn btn-success m-2" href=" {{ route('covers.done') }} "
                    role="button">La la liste des demandes traitées</a>
            @elseif (Route::currentRouteName() == 'covers.done')
                <a name="" id="" class="btn btn-secondary m-2" href=" {{ route('covers.index') }} "
                    role="button">Voir la liste de toutes les demandes </a>
            </div>
            <div class="col">
                <a name="" id="" class="btn btn-danger m-2" href=" {{ route('covers.undone') }} "
                    role="button">Voir la liste des demandes en attente</a>
            @elseif (Route::currentRouteName() == 'covers.undone')
                <a name="" id="" class="btn btn-secondary m-2" href=" {{ route('covers.index') }} "
                    role="button">Voir la liste de toutes les demandes </a>
            </div>
            <div class="col">
                <a name="" id="" class="btn btn-success m-2" href=" {{ route('covers.done') }} "
                    role="button">Voir les demandes de lettre de motivation traiteés</a>
                @endif
            </div>
        </div>
    </div>

    @foreach ($datas as $data)

        <div class="alert alert-{{ $data->done ? 'success' : 'dark' }}" role="alert">
            <div class="row row-cols-sm  ">
                <div class="col">
                    <p class="my-0">
                        <strong>
                            <span class="badge bg-dark">#{{$data->id}} </span>
                        </strong>

                        <small>
                            créée {{ $data->created_at->from() }} par {{ $data->name }}
                            @if ($data->coverAffectedTo && $data->coverAffectedTo->id == Auth::user()->id)
                                affectée à moi
                            @elseif ($data->coverAffectedTo)
                                {{ $data->coverAffectedTo ? ', affectée à '.$data->coverAffectedTo->name : '' }}
                                @if ($data->coverAffectedBy && $data->coverAffectedBy->id == Auth::user()->id)
                                    par moi-même
                                @else
                                    par {{-- {{ $data->coverAffectedBy->name }} --}}
                                @endif
                            @endif
                        </small>
                         

                        @if ($data->done)
                        <small>
                            <p>
                                Terminée
                                {{ $data->updated_at->from() }} - Terminée en
                                {{  $data->updated_at->diffForHumans($data->created_at,1) }}
                            </p>
                        </small>

                        @endif
                        {{-- <small>
                                <div class="alert alert-{{ $data->done ? 'success' : 'dark' }}" role="alert">
                                    <p>Statuts de la demande:</p>
                                    <ul>
                                            @foreach ($data->cvStatuses as $status)
                                                {{ $status->name }}
                                            @endforeach

                                    </ul>
                                </div>

                        </small> --}}
                    </p>
                            <strong>Nom & Prénom : {{ $data->name }} @if ($data->done)<span class="badge bg-success">Approuver</span>@endif</strong>
                            <br><strong>Numero de telephone : {{"$data->phone_number"}}</strong>

                </div>
                <div class="col-sm d-flex mx-1 justify-content-end my-1">
                    @if (auth()->user()->hasRole('operateur'))
                        <form action=" {{ route('covers.edit', $data->id) }} " method="get">
                            @csrf
                            <button type="submit" class="btn btn-info mx-1">Modifier</button>
                        </form>
                        @if ($data->done == 0)
                            <form action="{{ route('covers.makedone', $data->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success mx-1" style="min-width:150px">Terminée</button>
                            </form>
                        @else
                            <form action=" {{ route('covers.makeundone', $data->id) }} " method="post">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-secondary mx-1" style="min-width:150px">En cours</button>
                            </form>
                        @endif
                    @elseif (auth()->user()->hasRole('agentpublic'))
                        <form method="POST" action="{{ route('covers.approuver', $data->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">Approuver</button>
                        </form>
                        <form action=" {{ route('covers.destroy', $data->id) }} " method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mx-1">Rejeter</button>
                        </form>
                    @elseif (auth()->user()->hasRole('superviseur'))
                    <div class="dropdown open">
                        
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Affecté a
                        </button>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach ($users as $user)
                                @if ($user->hasRole('operateur'))
                                    <a class="dropdown-item" href="/covers/{{ $data->id }}/affectedTo/{{ $user->id }}">
                                        {{ $user->name }}
                                        <span class="ms-2 text-{{ $user->last_activity && $user->last_activity->diffInMinutes(now()) < 5 ? 'success' : 'secondary' }}">
                                            {{ $user->last_activity && $user->last_activity->diffInMinutes(now()) < 5 ? 'En ligne' : 'Hors ligne' }}
                                        </span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                        
                    </div>
                    @endif

                    
                </div>
            </div>


        </div>
    @endforeach

    {{ $datas->links() }}
@endsection
