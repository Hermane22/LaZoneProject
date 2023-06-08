@extends('layouts.app')

@section('content')
        {{-- <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title">Création d'une demande de conception de CV</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('cvs.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <h5>Nom et Prenom</h5>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp">
                        <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre nom au complet.</small>
                    </div>
                    <hr>
                    <div class="form-group">
                        <h5>Numero de telephone</h5>
                        <input type="text" name="phone_number" class="form-control" id="phone_number" aria-describedby="nameHelp">
                        <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre numero de telephone fonctionel.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
            </div>
        </div> --}}


        <div class="modal fade" id="ma-fenetre" tabindex="-1" aria-labelledby="ma-fenetre-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="ma-fenetre-label">Ma fenêtre</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title">Création d'une demande de conception de CV</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('cvs.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <h5>Nom et Prenom</h5>
                                    <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp">
                                    <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre nom au complet.</small>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <h5>Numero de telephone</h5>
                                    <input type="text" name="phone_number" class="form-control" id="phone_number" aria-describedby="nameHelp">
                                    <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre numero de telephone fonctionel.</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Valider</button>
                            </form>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          

@endsection
