<?php

namespace App\Http\Controllers;
use App\Models\Cv;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperiencesController extends Controller
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
    
    public function store(Request $request, $cv)
     {

    $durees = $request->input('durees');
    $entreprises = $request->input('entreprises');
    $departements = $request->input('departements');

    if (!empty($durees)) {
        foreach ($durees as $key => $duree) {
            Experience::updateOrCreate(
                [
                    'cv_id' => $cv,
                    'duree' => $duree
                    
                ],
                [
                    
                    'entreprise' => $entreprises[$key],
                    'departement' => $departements[$key]
                ]
            );
        }
    }
    return redirect()->back()->with('success', 'Les informations de l\'experience  ont bien été ajoutées.');
    
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function show(Experience $experience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function edit(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experience $experience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
            // Supprimer l'éducation
            $experience->delete();
    }
}
