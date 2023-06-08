@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Modification de la demande <span class="btn btn-dark">#{{ $cv->id }}</span></h4>
        </div>
        <div class="card-body">
            <form action="{{ route('cvs.update', $cv->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                    <div class="form-group my-1">
                        <label for="name">Nom et Prenom</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="nameHelp"
                            value=" {{ old('name', $cv->name) }} ">
                        <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre nom au complet.</small>
                    </div>
                    <div class="form-group my-2">
                        <label for="phone_number">Numero de telephone</label>
                        <input type="text" name="phone_number" class="form-control" id="phone_number"
                            aria-describedby="nameHelp" value=" {{ old('phone_number', $cv->phone_number) }} ">
                        <small id="nameHelp" class="form-text text-muted">Veuillez entrez votre numero de telephone
                            fonctionel.</small>
                    </div>
                    <div class="form-group my-2">
                        <h5>Charger le nouveau CV</h5>
                        <input type="file" name="fichier" class="form-control" id="fichier" aria-describedby="nameHelp">
                        <small id="nameHelp" class="form-text text-muted">Optionnel.</small>
                    </div>
                    <div class="form-group form-check my-2">
                        <div class="form-check">
                            <input id="done" class="form-check-input" type="checkbox" name="done"
                                {{ $cv->done ? 'checked' : '' }} value=1>
                            <label for="done" class="form-check-label">Terminé?</label>
                        </div>
                    </div>
                <button type="submit" class="btn btn-primary">Mettre a jour</button>
                <hr>
            
                {{-- education part --}}
                <h5>Education</h5>
                <form action="{{ route('educations.store', $cv->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="educations">
                                @if ($education->isEmpty())
                                    <div class="row mb-3 education justify-content-center">
                                        <div class="col-md-3">
                                            <label for="annees">Années</label>
                                            <input type="text" name="annees[]" class="form-control" id="annees" placeholder="01/01/2023 - 01/12/2023" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="etablissements">Etablissements</label>
                                            <input type="text" name="etablissements[]" class="form-control" id="etablissements" placeholder="Nom de l'école, ville, pays" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="diplomes">Diplômes</label>
                                            <input type="text" name="diplomes[]" class="form-control" id="diplomes" placeholder="Nom du diplôme, moyenne" value="">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove_education_btn">X</button>
                                        </div>
                                    </div>
                                @else
                        @foreach ($education as $edu)
                            <div class="row mb-3 education justify-content-center">
                                <div class="col-md-3">
                                    <label for="annees">Années</label>
                                    <input type="text" name="annees[]" class="form-control" id="annees"
                                        placeholder="01/01/2023 - 01/12/2023" value="{{ $edu->annee }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="etablissements">Etablissements</label>
                                    <input type="text" name="etablissements[]" class="form-control" id="etablissements"
                                        placeholder="Nom de l'école, ville, pays" value="{{ $edu->etablissement }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="diplomes">Diplômes</label>
                                    <input type="text" name="diplomes[]" class="form-control" id="diplomes"
                                        placeholder="Nom du diplôme, moyenne" value="{{ $edu->diplome }}">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <form action="{{ route('educations.destroy', ['cv' => $cv, 'education' => $edu]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">X</button>
                                    </form>
                                    
                                </div>
                                
                            </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary add_education_btn">Ajouter une éducation</button>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
                
                {{-- end of education part --}}
                <hr>

                {{-- Experience part --}}
                <h5>Experience Professionelle</h5>
                <form action="{{ route('experiences.store', $cv->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="experiences">
                        @if ($experience->isEmpty())
                        <div class="row mb-3 education justify-content-center">
                            <div class="col-md-3">
                                <label for="durees">Durée</label>
                                <input type="text" name="durees[]" class="form-control" id="durees"
                                placeholder="Durée" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="entreprises">Entreprises</label>
                                <input type="text" name="entreprises[]" class="form-control" id="entreprises"
                                placeholder="Nom de l'entreprise" value="">
                            </div>
                            <div class="col-md-3">
                                <label for="departements">Departements</label>
                                <input type="text" name="departements[]" class="form-control" id="departements"
                                placeholder="Département" value="">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove_experience_btn">X</button>
                            </div>
                        </div>
                    @else
                        @foreach ($experience as $exp)
                            <div class="row mb-3 experience justify-content-center">
                                <div class="col-md-3">
                                    <label for="durees">Durée</label>
                                    <input type="text" name="durees[]" class="form-control" id="durees"
                                    placeholder="Durée" value="{{ $exp->duree }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="entreprises">Entreprises</label>
                                    <input type="text" name="entreprises[]" class="form-control" id="entreprises"
                                    placeholder="Nom de l'entreprise" value="{{ $exp->entreprise }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="departements">Departements</label>
                                    <input type="text" name="departements[]" class="form-control" id="departements"
                                    placeholder="Département" value="{{ $exp->departement }}">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <form action="{{ route('experiences.destroy', $exp->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">X</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                    
                    <div class="text-center">
                        <button type="button" class="btn btn-primary add_experience_btn">Ajouter une experience</button>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            
                {{-- end of experience part --}}

                <hr>
                {{--Additional part --}}
                <h5>Informations Additionelles</h5>

                <form action="{{ route('infos.store', $cv->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="additionelles">
                        @foreach ($addInfo as $addinf)
                            <div class="row mb-3 additionelle justify-content-center">
                                <div class="col-md-3">
                                    <label for="competences[]">Competences</label>
                                    <input type="text" name="competences[]" class="form-control" id="competences[]"
                                    placeholder="Competences et autres qualifications" value="{{ $addinf->competence }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="loisirs">Loisirs</label>
                                    <input type="text" name="loisirs[]" class="form-control" id="loisirs"
                                    placeholder="Loisirs" value="{{ $addinf->loisirs }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="langues">Langues</label>
                                    <input type="text" name="langues[]" class="form-control" id="langues"
                                    placeholder="Langue" value="{{ $addinf->langue }}">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove_additionelle_btn">X</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary add_additionelle_btn">Ajouter une information additionelle</button>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </form>
                {{-- end of additional info part --}}
            

        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            const addItem = (form, placeholder, fields) => {
                $(form).prepend(`
                    <div class="row justify-content-center">
                        ${fields.map(field => `
                            <div class="col-md-3">
                                <label for="${field.name}[]">${field.label}</label>
                                <input type="text" name="${field.name}[]" class="form-control" placeholder="${field.placeholder}">
                            </div>
                        `).join('')}
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove_item_btn">X</button>
                        </div>
                    </div>
                `);
            }
    
            const removeItem = (btn) => {
                let button_id = $(btn).parent().parent();
                $(button_id).remove();
            }
    
            $(".add_education_btn").click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                addItem($(form).find('.educations'), "01/01/2023 - 01/12/2023", [
                    {name: "annees", label: "Années", placeholder: "01/01/2023 - 01/12/2023"},
                    {name: "etablissements", label: "Etablissements", placeholder: "Nom de l'école, ville, pays"},
                    {name: "diplomes", label: "Diplômes", placeholder: "Nom du diplôme, moyenne"}
                ]);
            });
    
            $(document).on('click', '.remove_education_btn', function(e) {
                e.preventDefault();
                removeItem($(this));
            });
            
    
            $(".add_experience_btn").click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                addItem($(form).find('.experiences'), "Durée", [
                    {name: "durees", label: "Durée", placeholder: "Durée"},
                    {name: "entreprises", label: "Entreprises", placeholder: "Nom de l'entreprise"},
                    {name: "departements", label: "Départements", placeholder: "Département"}
                ]);
            });
    
            $(document).on('click', '.remove_experience_btn', function(e) {
                e.preventDefault();
                removeItem($(this));
            });
    
            $(".add_additionelle_btn").click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                addItem($(form).find('.additionelles'), "Compétences et autres qualifications", [
                    {name: "competences", label: "Compétences", placeholder: "Compétences et autres qualifications"},
                    {name: "loisirs", label: "Loisirs", placeholder: "Loisirs"},
                    {name: "langues", label: "Langues", placeholder: "Langue"}
                ]);
            });
    
            $(document).on('click', '.remove_additionelle_btn', function(e) {
                e.preventDefault();
                removeItem($(this));
            });
        });
    </script>
    
    
    
    
@endsection
