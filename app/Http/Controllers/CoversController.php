<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cover;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\CoverAffected;
use Illuminate\Support\Facades\Auth;

class CoversController extends Controller
{

    public $users;

    public function __construct()
    {
        $this->users = User::getAllUsers();
    }

    public function affectedTo(Cover $cover , User $user)
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
            $cover->operateur_id = $user->id;
            $cover->affectedBy_id = auth()->user()->id;
            $cover->save();
            
    
            // Envoie une notification à l'utilisateur affecté
            $user->notify(new CoverAffected($cover));
    
            return redirect()->back()->with('success', 'La demande a été affectée à l\'opérateur avec succès.');
    }

    public function approuver($id)
    {
        // Rechercher un utilisateur qui a le rôle approprié
        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'superviseur');
        })->first();

        // Récupérer la demande de CV à approuver
        $cover = Cover::findOrFail($id);

        // Affecter la demande de CV à l'utilisateur qui a le rôle approprié
        $cover->users()->sync([$user->id]);

        // Rediriger vers la page d'index des demandes de CV
        return redirect()->route('covers.index');
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
                $datas = Cover::whereHas('users', function ($query) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'agentpublic');
                    });
                })->orderBy('id', 'desc')->paginate(10);
            } elseif (in_array('superviseur', $roles)) {
                $datas = Cover::whereHas('users', function ($query) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'superviseur');
                    });
                })->orderBy('id', 'desc')->paginate(10);
            } elseif (in_array('operateur', $roles)) {
                $operateurId = auth()->user()->id;
                $datas = Cover::where('operateur_id', $operateurId)
                    ->with('status')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
            }
            else {
                
                $datas = [];
            }
        return View('covers.index', compact('datas', 'users'));
    }


    public function affected()
    {
        $userId = Auth::user()->id;
        $users= $this->users;
        $datas = Cover::withTrashed()->paginate(10);
        return View('covers.affected', compact('datas', 'users'));
    }

    public function done()
    {
        $userId = Auth::user()->id;
        $datas = Cover::where([
            'done'=>1,
            'affectedTo_id'=> $userId
            ])->paginate(10);
        $users= $this->users;
        return View('covers.index', compact('datas' , 'users'));
    }

    public function undone()
    {
        $userId = Auth::user()->id;
        $datas = Cover::where([
            'done'=>0,
            'affectedTo_id'=> $userId
            ])->paginate(10);
        $users= $this->users;
        return View('covers.index', compact('datas' , 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('covers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cover = new Cover();
        $cover->name = $request->name;
        $cover->phone_number = $request->phone_number;
        
        $cover->save();

        // Récupération des utilisateurs ayant le rôle "superviseur"
        
        $agentpublics = User::whereHas('roles', function ($query) {
            $query->where('name', 'agentpublic');
        })->get();
        
        // Affectation de la demande de CV aux superviseurs
        foreach ($agentpublics as $agentpublic) {
            $agentpublic->coverRequests()->attach($cover->id);
            }
        return redirect(route('welcome'))->with('success', 'Votre demande de redaction de lettre de motivation a bien été enregistrée. Un agent vour feras signe très prochainement.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cover  $cover
     * @return \Illuminate\Http\Response
     */
    public function show(Cover $cover)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cover  $cover
     * @return \Illuminate\Http\Response
     */
    public function edit(Cover $cover)
    {
        return view('covers.edit', compact('cover'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cover  $cover
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cover $cover)
    {
        $password = Str::random(16);
        $filename = time(). '.' . $request->fichier->extension();
        $path=$request->file('fichier')->storeAs(
            'dossier_cover',
            $filename,
            'public'
        );
        if(!isset($request->done)){
            $request['done'] = 0;
        }
        $cover->download_pass = $password;
        $cover->url = $path;
       // $link = route('covers.download', ['id' => $cover->id, 'password' => $password]);


        $cover->update($request->all());
        return redirect()->route('covers.index')->with('success', 'La demande a bien été modifier.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cover  $cover
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cover $cover)
    {
        if ($cover->done == 1) {
            return back()->with('error', 'Vous ne pouvez pas supprimer une demande qui a été acceptée.');
        }
        $cover->delete();
        return back()->with('success', 'La demande a été supprimée.');
    }

    public function makedone(Cover $cover)
    {
        $cover->done=1;
        $cover->update();
        return back()->with('success','La demande de lettre de motivation a bien été approuvée.');
    }

    public function makeundone(Cover $cover)
    {
        $cover->done=0;
        $cover->update();
        return back()->with('success','La demande de lettre de motivation a été mise en attente.');;
    }
}
