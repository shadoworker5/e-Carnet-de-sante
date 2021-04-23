@extends('layouts.app', ['title' => 'Liste des patients ajoutés'])

@section('main_content')
    <div class="row mb-2">
        <h1 class="text-center mt-3"> Liste des patients ajoutés </h1>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th> {{ __('Nom complet') }} </th>

                        <th> {{ __('Date de naissance') }} </th>

                        <th> {{ __('Genre') }} </th>

                        <th> {{ __('Lieu de naissance') }} </th>

                        <th> {{ __('Nom du père') }} </th>

                        <th> {{ __('Nom de la mère') }} </th>

                        <th> {{ __('Personne à prévenir en cas de besoin') }} </th>

                        <th> {{ __('Contact') }} </th>

                        <th> {{ __('Action') }} </th>
                    </tr>
                </thead>

                <tbody id="list_patient_add">
                    {{-- @forelse($submissions as $submission)
                        <tr id="{{ ++$loop->index }}">
                            <td> {{ getPatientName($submission->patient_id) }} </td>

                            <td> {{ get_vaccine_name($submission->vaccine_calendar_id) }} </td>

                            <td> {{ $submission->date_vacination }} </td>

                            <td> {{ format_vaccinate_time($submission->time_vacination) }} </td>

                            <td> {{ $submission->lot_number_vacine }} </td>

                            <td> {{ $submission->rappelle !== null ? $submission->rappelle : 'NP' }} </td>

                            <td> {{ $submission->name_doctor }} </td>

                            <td> {{ $submission->doctor_contact }} </td>

                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('vaccinate.edit', $submission) }}" id="vacinate_{{++$loop->index}}" class="btn text-white btn_color btn_update">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <p class="text-danger text-center"> Aucune ligne trouvée</p>
                            </td>
                        </tr>
                    @endforelse --}}
                </tbody>
            </table>
        </div>

        <div class="col-md-2">
            <a href="#" onclick="javascript:history.back();" class="btn bg_color text-white">
                <i class="fa fa-arrow-left"></i>
                Revenir en arrière
            </a>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="edit_patient_add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('Modifier le patient') }} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="#" id="form_edit_patient" method="post">
                        <div class="form-group">
                            <label class="control-label" for="name"> {{ __('Nom complet') }} </label>
                            <input type="text" class="form-control" required name="name" id="name" placeholder="Nom complet">

                            <div class="invalid-feedback">
                                Veuillez saisir le nom du patient
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="birthday"> {{ __('Date de naissance') }} </label>
                            <input type="date" class="form-control" name="birthday" value="{{ old('birthday') }}" required id="birthday"/>

                            <div class="invalid-feedback">
                                Veuillez choisir la date de naissance
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="genre"> {{ __('Genre') }} </label>
                            <select class="form-control custom-select" required name="genre" id="genre">
                                <option value=""> Veuilez choisir le genre </option>
                                <option value="M"> {{ __("Homme") }} </option>
                                <option value="F"> {{ __("Femme") }} </option>
                            </select>

                            <div class="invalid-feedback">
                                Veuillez choisir le genre du patient
                            </div>
                        </div>

                        @include('layouts.partials.choose_province')

                        <div class="form-group">
                            <label class="control-label" for="born_location"> {{ __('Lieu de naissance') }} </label>
                            <input type="text" class="form-control" name="born_location" id="born_location" required placeholder="Lieu de naissance">

                            <div class="invalid-feedback">
                                Veuillez choisir une province
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="father_name"> {{ __('Nom du père') }} </label>
                            <input type="text" class="form-control" name="father_name" id="father_name" required placeholder="Nom du père">

                            <div class="invalid-feedback">
                                Veuillez saisir le nom du père
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="mother_name"> {{ __('Nom de la mère') }} </label>
                            <input type="text" class="form-control" name="mother_name" required id="mother_name" placeholder="Nom de la mère">

                            <div class="invalid-feedback">
                                Veuillez saisir le nom de mère
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="mentor_name"> {{ __('Personne à prévenir en cas de besoin') }} </label>
                            <input type="text" class="form-control" name="mentor_name" required id="mentor_name" placeholder="Nom du personne à prévenir">

                            <div class="invalid-feedback">
                                Veuillez saisir le nom du personne à prévenir
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="helper_contact"> {{ __('Contact en cas de besoin') }} </label>
                            <input type="text" class="form-control" required name="helper_contact" id="helper_contact" placeholder="Contact en cas de besoin">

                            <div class="invalid-feedback">
                                Veuillez saisir le contact
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <label class="control-label" for="helper_email"> {{ __('E-mail (facultatif)') }} </label>
                            <input type="text" class="form-control" name="helper_email" id="helper_email" placeholder="E-mail (NP par défaut)">

                        </div>

                        <div class="mt-2 align-center offset-md-4">
                            <button class="btn btn-danger" onclick="javascript:history.back();">
                                {{ __('Annuler') }}
                            </button>

                            <button type="submit" id="submit_vacinate_edit" class="btn btn-primary">
                                {{ __('Modifier') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> {{ __("Fermer") }} </button>
                </div>
            </div>
        </div>
    </div>
@endsection
