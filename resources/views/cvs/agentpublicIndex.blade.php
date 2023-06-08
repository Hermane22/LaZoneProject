@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row row-cols-auto justify-content-center">

            <div class="col">
                <a name="" id="" class="btn btn-secondary m-2" href=" {{ route('cvs.agentpublic') }} "
                    role="button">Voir toutes les demandes </a>
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
                            créée {{$data->created_at->from() }} par
                            {{ $data->name }}
                            @if ($data->cvAffectedTo && $data->cvAffectedTo->id == Auth::user()->id)
                            affectée à moi

                            @elseif ($data->cvAffectedTo)
                            {{ $data->cvAffectedTo ? ', affectée à '.$data->cvAffectedTo->name : '' }}

                            @endif
                        </small> 
                    </p>
                    <strong>Nom & Prénom : {{ $data->name }} @if ($data->done)<span class="badge bg-success">Approuver</span>@endif</strong>
                    <br><strong>Numero de telephone : {{"$data->phone_number"}}</strong>

                </div>

                <div class="col-sm d-flex mx-1 justify-content-end my-1">

                    <form method="POST" action="{{ route('cvs.approuver', $data->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-success">Approuver</button>
                    </form>

                    <form action=" {{ route('cvs.destroy', $data->id) }} " method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mx-1">Rejeter</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- {{ $datas->links() }} --}}
@endsection
