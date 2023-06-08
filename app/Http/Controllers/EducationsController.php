<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Http\Controllers\CvController;

class EducationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $cv )
    {
        $annees = $request->input('annees');
        $etablissements = $request->input('etablissements');
        $diplomes = $request->input('diplomes');
        
        if (!empty($annees)) {
            foreach ($annees as $key => $annee) {
                Education::updateOrCreate(
                    [
                        'cv_id' => $cv,
                        'annee' => $annee
                        
                    ],
                    [
                        
                        'etablissement' => $etablissements[$key],
                        'diplome' => $diplomes[$key]
                    ]
                );
            }
        }
          
        
        
        return redirect()->back()->with('success', 'La demande a bien été modifier.'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function show(Education $education)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function edit($cv_id)
    {
            // Récupère les données d'éducation pour le CV spécifié
    $education = Education::where('cv_id', $cv_id)->get();

    // Renvoie la vue d'édition avec les données d'éducation
    return view('education.edit', compact('education', 'cv_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cv_id)
    {
        // Récupère les données d'éducation pour le CV spécifié
        $education = Education::where('cv_id', $cv_id)->get();

        // Boucle sur les données d'éducation et met à jour chaque enregistrement
        foreach ($education as $key => $edu) {
            $edu->annee = $request->input('annees.' . $key);
            $edu->etablissement = $request->input('etablissements.' . $key);
            $edu->diplome = $request->input('diplomes.' . $key);
            $edu->save();
        }

        // Redirige l'utilisateur vers la page d'édition avec un message de succès
        return redirect()->route('education.edit', $cv_id)->with('success', 'Les données d\'éducation ont été mises à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function destroy(Education $education)
    {
        $education = Education::find($education->id);
        dd($education);
        die();
    // Supprimer l'éducation
        $education->delete();

        return redirect()->back()->with('success', 'Éducation supprimée avec succès.');
    }
}
