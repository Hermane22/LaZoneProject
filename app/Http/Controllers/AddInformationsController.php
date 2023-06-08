<?php

namespace App\Http\Controllers;

use App\Models\AddInformation;
use Illuminate\Http\Request;

class AddInformationsController extends Controller
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
        $competences = $request->input('competences');
        $loisirs = $request->input('loisirs');
        $langues = $request->input('langues');

        if (!empty($competences)) {
            foreach ($competences as $key => $competence) {
                AddInformation::updateOrCreate(
                    [
                        'cv_id' => $cv,
                        'competence' => $competence,
                        
                    ],
                    [
                        
                        'loisirs' => $loisirs[$key],
                        'langue' => $langues[$key]
                    ]
                );
            }
        } 

        return redirect()->back()->with('success', 'Les informations supplementaire ont bien été ajoutées.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AddInformation  $addInformation
     * @return \Illuminate\Http\Response
     */
    public function show(AddInformation $addInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AddInformation  $addInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(AddInformation $addInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AddInformation  $addInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AddInformation $addInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AddInformation  $addInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(AddInformation $addInformation)
    {

    }
}
