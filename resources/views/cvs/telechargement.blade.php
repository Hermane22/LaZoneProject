@extends('layouts.app')

@section('content')
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title">Création d'une demande de conception de CV</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('cvs.telecharger') }}">
                    @csrf
                    <label for="numero">Numéro :</label>
                    <input type="text" id="numero" name="numero" required>
                    <button type="submit">Générer un code OPT</button>
                </form>                
                
            </div> 
        </div>

@endsection
