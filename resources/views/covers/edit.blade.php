@extends('layouts.app')

@section('content')
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Modification de la demande de conception de lettre de motivation <span class="btn btn-dark">#{{$cover->id}}</span></h4>
            </div>
            <div class="card-body">
                <form action="{{ route('covers.update', $cover->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group my-1">
                        <label for="name">Nom et Prenom</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp" value=" {{old('name', $cover->name)}} ">
                        <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre nom au complet.</small>
                    </div>
                    <div class="form-group my-2">
                        <label for="phone_number">Numero de telephone</label>
                        <input type="text" name="phone_number" class="form-control" id="phone_number" aria-describedby="nameHelp" value=" {{old('phone_number', $cover->phone_number)}} ">
                        <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre numero de telephone fonctionel.</small>
                    </div>                    
                    
                    <hr>


                    <div class="form-group my-2">
                        <h5>Charger le fichier</h5>
                        <input type="file" name="fichier" class="form-control" id="fichier" aria-describedby="nameHelp">
                        <small id="nameHelp" class="form-text text-muted">Optionnel.</small>
                    </div>

                    <div class="form-group form-check my-2">
                        <div class="form-check">
                            <input id="done" class="form-check-input" type="checkbox" name="done" {{$cover->done ? 'checked': ''}} value=1>
                            <label for="done" class="form-check-label">Approuve?</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre a jour</button>
                </form>
            </div>

        </div>
@endsection
