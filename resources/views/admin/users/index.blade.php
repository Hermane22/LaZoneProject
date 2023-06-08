@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Liste des Utilisateurs</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Rôle</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                  
                                    <tr>
                                        <th scope="row">{{ $user->id }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{implode(', ',$user->roles()->get()->pluck('name')->toArray())}}</td>
                                        <td>
                                            <a href="{{route('users.edit' , $user->id)}}"> <button class="btn btn-primary"> Editer</button> </a>
                                            
                                            <form action="{{route('users.destroy', $user->id)}}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-warning"> Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
