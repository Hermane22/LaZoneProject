<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cover;
use App\Models\Memory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MemoryAffected;

class MemoryController extends Controller
{
    public $users;

    public function __construct()
    {
        $this->users = User::getAllUsers();
    }

    public function affectedTo(Memory $memory , User $user)
    {
            // Vérifie si l'utilisateur connecté a le rôle "superviseur"
            if (!auth()->user()->hasRole('superviseur')) {
                return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à affecter des demandes.');
            }
    
            // Vérifie si l'utilisateur affecté est un opérateur
            if (!$user->hasRole('operateur')) {
                return redirect()->back()->with('error', 'Vous ne pouvez affecter la demande qu\'à un opérateur.');
            }
    
            // Met à jour les informations de l'affectation
            $memory->operateur_id = $user->id;
            $memory->affectedBy_id = auth()->user()->id;
            $memory->save();
    
            // Envoie une notification à l'utilisateur affecté
            $user->notify(new MemoryAffected($memory));
    
            return redirect()->back()->with('success', 'La demande a été affectée à l\'opérateur avec succès.');
    }

    public function approuver($id)
    {
        // Rechercher un utilisateur qui a le rôle approprié
        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'superviseur');
        })->first();

        // Récupérer la demande de CV à approuver
        $memory = Memory::findOrFail($id);

        // Affecter la demande de CV à l'utilisateur qui a le rôle approprié
        $memory->users()->sync([$user->id]);

        // Rediriger vers la page d'index des demandes de CV
        return redirect()->route('memory.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $roles = $user->roles->pluck('name')->toArray();
        $users = $this->users;

            if (in_array('agentpublic', $roles)) {
                $datas = Memory::whereHas('users', function ($query) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'agentpublic');
                    });
                })->orderBy('id', 'desc')->paginate(10);
            } elseif (in_array('superviseur', $roles)) {
                $datas = Memory::whereHas('users', function ($query) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'superviseur');
                    });
                })->orderBy('id', 'desc')->paginate(10);
            } elseif (in_array('operateur', $roles)) {
                $operateurId = auth()->user()->id;
                $datas = Memory::where('operateur_id', $operateurId)
                    ->with('status')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
            }
            else {
                
                $datas = [];
            }
        return View('memory.index', compact('datas', 'users'));
    }
    public function affected()
    {
        $userId = Auth::user()->id;
        $users= $this->users;        
       $datas = Memory::withTrashed()->paginate(10);
        return View('cvs.affected', compact('datas', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('memory.create');
    }

    public function done()
    {
        $userId = Auth::user()->id;
        $datas = Memory::where([
            'done'=>1,
            'affectedTo_id'=> $userId
            ])->paginate(10);
        $users= $this->users;
        return View('memory.index', compact('datas' , 'users'));
    }

    public function undone()
    {
        $userId = Auth::user()->id;
        $datas = Memory::where([
            'done'=>0,
            'affectedTo_id'=> $userId
            ])->paginate(10);
        $users= $this->users;
        return View('memory.index', compact('datas' , 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $memory = new Memory();
        $memory->name = $request->name;
        $memory->phone_number = $request->phone_number;
        $memory->save();

            // Récupération des utilisateurs ayant le rôle "superviseur"
    
            $agentpublics = User::whereHas('roles', function ($query) {
                $query->where('name', 'agentpublic');
            })->get();
            
            // Affectation de la demande de CV aux superviseurs
            foreach ($agentpublics as $agentpublic) {
                $agentpublic->memoryRequests()->attach($memory->id);
                }
        return redirect(route('welcome'))->with('success', 'Votre demande de correction de memoire a bien été enregistrée. Un agent vour feras signe très prochainement.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function show(Memory $memory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function edit(Memory $memory)
    {
        return view('memory.edit', compact('memory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Memory $memory)
    {
        $password = Str::random(16);
        $filename = time(). '.' . $request->fichier->extension();
        $path=$request->file('fichier')->storeAs(
            'dossier_memoire',
            $filename,
            'public'
        );
        if(!isset($request->done)){
            $request['done'] = 0;
        }
        $memory->download_pass = $password;
        $memory->url = $path;
       // $link = route('memory.download', ['id' => $memory->id, 'password' => $password]);


        $memory->update($request->all());
        return redirect()->route('memory.index')->with('success', 'La demande a bien été modifier.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Memory $memory)
    {
        if ($memory->done == 1) {
            return back()->with('error', 'Vous ne pouvez pas supprimer une demande qui a été acceptée.');
        }
        $memory->delete();
        return back()->with('success', 'La demande a été supprimée.');
    }

    public function makedone(Memory $memory)
    {
        $memory->done=1;
        $memory->update();
        return back()->with('success','La demande de correction de memoire a bien été approuvée.');
    }

    public function makeundone(Memory $memory)
    {
        $memory->done=0;
        $memory->update();
        return back()->with('success','La demande de correction de memoire a été mise en attente.');;
    }
}
