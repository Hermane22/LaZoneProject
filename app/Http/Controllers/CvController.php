<?php

namespace App\Http\Controllers;


use App\Models\Cv;
use App\Models\User;
use App\Models\Education;
use App\Models\Experience;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AddInformation;
use App\Notifications\CvAffected;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\EducationsController;
use App\Http\Controllers\ExperiencesController;
use App\Http\Controllers\AddInformationsController;


class CvController extends Controller
{

    public $users;

    public function __construct()
    {
        $this->users = User::getAllUsers();
    }

    public function affectedTo(Cv $cv , User $user)
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
        $cv->operateur_id = $user->id;
        $cv->affectedBy_id = auth()->user()->id;
        $cv->save();

        // Envoie une notification à l'utilisateur affecté
        $user->notify(new CvAffected($cv));

        return redirect()->back()->with('success', 'La demande a été affectée à l\'opérateur avec succès.');

        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function approuver($id)
    {
        // Rechercher un utilisateur qui a le rôle approprié
        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'superviseur');
        })->first();

        // Récupérer la demande de CV à approuver
        $cv = Cv::findOrFail($id);

        // Affecter la demande de CV à l'utilisateur qui a le rôle approprié
        $cv->users()->sync([$user->id]);

        // Rediriger vers la page d'index des demandes de CV
        return redirect()->route('cvs.index');
    } 

    public function index()
    {

        $user = auth()->user();
        $roles = $user->roles->pluck('name')->toArray();
        $users = $this->users;

            if (in_array('agentpublic', $roles)) {
                $datas = Cv::whereHas('users', function ($query) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'agentpublic');
                    });
                })->orderBy('id', 'desc')->paginate(10);
            } elseif (in_array('superviseur', $roles)) {
                $datas = Cv::whereHas('users', function ($query) {
                    $query->whereHas('roles', function ($query) {
                        $query->where('name', 'superviseur');
                    });
                })->orderBy('id', 'desc')->paginate(10);
            } elseif (in_array('operateur', $roles)) {
                $operateurId = auth()->user()->id;
                $datas = Cv::where('operateur_id', $operateurId)
                    ->with('status')
                    ->orderBy('id', 'desc')
                    ->paginate(10);
            }
            else {
                
                $datas = [];
            }
    
        return view('cvs.index', compact('datas', 'users'));
    }
    
     public function terminer($id)
    {
        $cv = Cv::find($id);

        if (!$cv) {
            return redirect()->back()->with('error', 'La demande n\'existe pas.');
        }

        // Vérifie si l'utilisateur connecté est l'opérateur qui a été affecté à la demande
        if (auth()->user()->id != $cv->operateur_id) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à terminer cette demande.');
        }

        // Met à jour la demande pour indiquer qu'elle est terminée
        $cv->cv_status_id = 3; // Remplacer 3 par l'identifiant de l'état "Terminée" dans votre base de données
        $cv->save();

        return redirect()->back()->with('success', 'La demande a été marquée comme terminée.');
    }   



    public function done()
    {
        $userId = Auth::user()->id;
        $datas = Cv::where([
            'done'=>1,
            'affectedTo_id'=> $userId
            ])->paginate(10);
        $users= $this->users;
        return View('cvs.index', compact('datas' , 'users'));
    }

    public function affected()
    {
        $userId = Auth::user()->id;
        $users= $this->users;
        $datas = Cv::withTrashed()->paginate(10);
        return View('cvs.affected', compact('datas', 'users'));
    }

    public function undone()
    {
        $userId = Auth::user()->id;
        $datas = Cv::where([
            'done'=>0,
            'affectedTo_id'=> $userId
            ])->paginate(10);
        $users= $this->users;
        return View('cvs.index', compact('datas' , 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cvs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cv = new Cv();
        $cv->name = $request->name;
        $cv->phone_number = $request->phone_number;
        
        $cv->save();
        

        // Récupération des utilisateurs ayant le rôle "superviseur"
        
        $agentpublics = User::whereHas('roles', function ($query) {
            $query->where('name', 'agentpublic');
        })->get();
        
        // Affectation de la demande de CV aux superviseurs
        foreach ($agentpublics as $agentpublic) {
            $agentpublic->cvRequests()->attach($cv->id);
            
            }
        return redirect(route('welcome'))->with('success', 'Votre demande de conception de Cv a bien été enregistrée. Un agent vour feras signe très prochainement.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cv $cv)
    {
        
        // Récupère les données d'éducation, d'expérience et d'informations additionnelles pour le CV spécifié
        $education = Education::where('cv_id', $cv->id)->get();
        //$education = $cv->education;*

        
        $experience = Experience::where('cv_id', $cv->id)->get();
        /* dd($experience);
        die(); */
        $addInfo = AddInformation::where('cv_id', $cv->id)->get();

        // Renvoie la vue d'édition avec les données récupérées et l'ID du CV
        return view('cvs.edit', compact('cv', 'education', 'experience', 'addInfo'));
            //return view('cvs.edit', compact('cv'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* public function update(Request $request,Cv $cv)
    {
        
       
        $password = Str::random(16);

        $filename = time(). '+' . $request->name . '.' .$request->fichier->extension();
        $path=$request->file('fichier')->storeAs(
            'dossier_cv',
            $filename,
            'public'
        ); 
        

        if(!isset($request->done)){
            $request['done'] = 0;
        }        

        $cv->update($request->all());

        //store($request , $cv )
        
        
        $educationsController = new EducationsController;
        $educationsController->store($request, $cv); 
        
        $experiencesController = new ExperiencesController;
        $experiencesController->store($request, $cv);

        $addInformationsController = new AddInformationsController;
        $addInformationsController->store($request, $cv);


        // Mettre à jour les données d'éducation
    $educationData = $request->input('education');
    foreach ($educationData as $key => $edu) {
        $education = Education::findOrFail($edu['id']);
        $education->annee = $edu['annee'];
        $education->etablissement = $edu['etablissement'];
        $education->diplome = $edu['diplome'];
        $education->save();
    }

    // Mettre à jour les données d'expérience
    $experienceData = $request->input('experience');
    foreach ($experienceData as $key => $exp) {
        $experience = Experience::findOrFail($exp['id']);
        $experience->duree = $exp['duree'];
        $experience->entreprise = $exp['entreprise'];
        $experience->departement = $exp['departement'];
        $experience->save();
    }

    // Mettre à jour les données d'informations additionnelles
    $addInfoData = $request->input('add_info');
    foreach ($addInfoData as $key => $info) {
        $addInfo = AddInfo::findOrFail($info['id']);
        $addInfo->titre = $info['titre'];
        $addInfo->description = $info['description'];
        $addInfo->save();
    }


    return redirect()->route('cvs.edit', $cv)->with('success', 'Les données ont été mises à jour avec succès.');
        //return redirect()->route('cvs.index')->with('success', 'La demande a bien été modifier.');
        
    } */

    public function update(Request $request, Cv $cv)
{
    $password = Str::random(16);

    if ($request->hasFile('fichier')) {
        $filename = time() . '+' . $request->name . '.' . $request->file('fichier')->extension();
        $path = $request->file('fichier')->storeAs(
            'dossier_cv',
            $filename,
            'public'
        );
    } else {
        // Gérer le cas où aucun fichier n'est téléchargé
        $path = ''; // Par exemple, vous pouvez attribuer une valeur par défaut au chemin du fichier
    }
    

    if (!isset($request->done)) {
        $request['done'] = 0;
    }        

    $cv->update($request->all());

    // Store($request , $cv )
        
    $educationsController = new EducationsController;
    $educationsController->store($request, $cv); 
        
    $experiencesController = new ExperiencesController;
    $experiencesController->store($request, $cv);

    $addInformationsController = new AddInformationsController;
    $addInformationsController->store($request, $cv);

    /* // Mettre à jour les données d'éducation
    $educationData = $request->input('education');
    dd($educationData);
    die();
    foreach ($educationData as $key => $edu) {
        Education::updateOrCreate(['id' => $edu['id']], [
            'cv_id' => $cv->id,
            'annee' => $edu['annees'],
            'etablissement' => $edu['etablissements'],
            'diplome' => $edu['diplomes']
        ]);
    }

    // Mettre à jour les données d'expérience
    $experienceData = $request->input('experience');
    foreach ($experienceData as $key => $exp) {
        Experience::updateOrCreate(['id' => $exp['id']], [
            'cv_id' => $cv->id,
            'duree' => $exp['duree'],
            'entreprise' => $exp['entreprise'],
            'departement' => $exp['departement']
        ]);
    }

    // Mettre à jour les données d'informations additionnelles
    $addInfoData = $request->input('add_info');
    foreach ($addInfoData as $key => $info) {
        AddInfo::updateOrCreate(['id' => $info['id']], [
            'cv_id' => $cv->id,
            'titre' => $info['titre'],
            'description' => $info['description']
        ]);
    } */

    return redirect()->route('cvs.edit', $cv)->with('success', 'Les données ont été mises à jour avec succès.');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cv $cv)
    {
        dd($cv);
        die();
        $cv->delete();
        return back()->with('success', 'La demande a été supprimée.');
    }

    public function destroyEducation(Cv $cv, Education $education)
    {
        // Vérifier si l'éducation appartient bien au CV
        if ($cv->id !== $education->cv_id) {
            abort(404);
        }

        // Supprimer l'éducation
        $education->delete();

        return redirect()->back()->with('success', 'Éducation supprimée avec succès.');
    }

    public function destroyExperience(Cv $cv, Experience $experience)
    {
        // Vérifier si l'expérience appartient bien au CV
        if ($cv->id !== $experience->cv_id) {
            abort(404);
        }

        // Supprimer l'expérience
        $experience->delete();

        return redirect()->back()->with('success', 'Expérience supprimée avec succès.');
    }

    public function destroyAddInformation(Cv $cv, AddInformation $addInformation)
    {
        // Vérifier si l'information supplémentaire appartient bien au CV
        if ($cv->id !== $addInformation->cv_id) {
            abort(404);
        }

        // Supprimer l'information supplémentaire
        $addInformation->delete();

        return redirect()->back()->with('success', 'Information supplémentaire supprimée avec succès.');
    }







    public function makedone(Cv $cv)
    {
        $cv->done=1;
        $cv->update();
        return back()->with('success','La demande de cv a bien été approuvée.');
    }

    public function makeundone(Cv $cv)
    {
        $cv->done=0;
        $cv->update();
        return back()->with('success','La demande de cv a été mise en attente.');
    }

    public function telecharger(Request $request)
{
    $codeSaisi = $request->input('codeOPT');
    $codeStocke = session('codeOPT');
    /* if ($codeSaisi == $codeStocke) {
        return response()->download(storage_path(''));
    } else {
        return redirect()->back()->withErrors(['codeOPT' => 'Le code OPT saisi est incorrect.']);
    } */

    return view('cvs.telechargement');
}

    public function CvDetail(Cv $cv , $password)
    {
        
        return view('cvs.cvdetail');
    }

    public function telechargement(Request $request)
{
    $numero = $request->input('numero');
    $codeOPT = rand(100000, 999999);
    session(['codeOPT' => $codeOPT]);
    //return redirect()->back();
    return view('cvs.telechargement');
}
}