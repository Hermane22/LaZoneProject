@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row row-cols-auto justify-content-center">


            <div class="col">
                
                    <a name="" id="" class="btn btn-secondary m-2" href=" {{ route('cvs.affected') }} "
                        role="button">Les demandes de Cv</a>
            </div>
            <div class="col">
                <a name="" id="" class="btn btn-secondary m-2" href=" {{ route('covers.affected') }} "
                    role="button">Les demandes de lettre de motivation</a>
            
                <a name="" id="" class="btn btn-secondary m-2" href=" {{ route('memory.affected') }} "
                    role="button">Les demande de correction de memoire </a>
            </div>
        </div>
    </div>

    @foreach ($datas as $data)

    <div class="alert alert-{{ $data->deleted_at ? 'danger' : 'dark' }} " role="alert">
        <div class="row row-cols-sm  ">
            <div class="col">
                <p class="my-0">
                    <strong>
                        <span class="badge bg-dark">#{{$data->id}} </span>
                    </strong>

                    <small>
                        créée {{$data->created_at->from() }} par
                        {{ $data->name }}
                        @if ($data->cvAffectedTo && $data->cvAffectedTo->id == Auth::user()->id)
                        affectée à moi

                        @elseif ($data->cvAffectedTo)
                        {{ $data->cvAffectedTo ? ', affectée à '.$data->cvAffectedTo->name : '' }}

                        @endif

                        {{-- autre personne--}}

                        {{-- @if ($data->cvAffectedTo && $data->cvAffectedBy && $data->cvAffecteBy->id ==
                        Auth::user()->id)
                        par moi même :D

                        @elseif ($data->cvAffectedTo && $data->cvAffectedBy && $data->cvAffecteBy->id !=
                        Auth::user()->id)
                        par {{ $data->cvAffectedBy->name }}

                        @endif--}}
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
                </p>
                        <strong>Nom & Prénom : {{ $data->name }} @if ($data->done)<span class="badge bg-success">Approuver</span>@endif</strong>
                        <br><strong>Numero de telephone : {{"$data->phone_number"}}</strong>

                        
                    
                

            </div>
            <div class="col-sm d-flex mx-1 justify-content-end my-1">
                
                <div class="dropdown open">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Affecté a
                    </button>
                    
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach ($users as $user)
                            <a class="dropdown-item"
                                href="/cvs/{{ $data->id }}/affectedTo/{{ $user->id }}">{{ $user->name }}</a>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>


    </div>
@endforeach



    {{ $datas->links() }}
@endsection
