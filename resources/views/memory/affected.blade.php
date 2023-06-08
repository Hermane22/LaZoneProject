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
@endsection
