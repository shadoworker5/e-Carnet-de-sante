@extends('layouts.app', ['title' => 'Liste des vaccinations'])

@section('main_content')
    <div class="row mb-2">
        <h1 class="text-center mt-3"> Liste des vaccinations </h1>

        <!-- <div class="row mt-4">
            <div class="col-md-10">
                <label for="search" class="sr-only"> Rechercher </label>
                <input type="text" placeholder="Nom ou code" wire:model="search" id="search" name="search"/>
            </div>
        </div> -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th> {{ __('Code patient') }} </th>

                        <th> {{ __('Vaccin') }} </th>

                        <th> {{ __('Date') }} </th>

                        <th> {{ __('Heure') }} </th>

                        <th> {{ __('Numéro du vaccin') }} </th>

                        <th> {{ __('Rappel') }} </th>

                        <th> {{ __('Nom de l\'agent') }} </th>

                        <th> {{ __('Contact') }} </th>

                        <th> {{ __('Action') }} </th>
                    </tr>
                </thead>

                <tbody id="list_patient">
                    @forelse($submissions as $submission)
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
                    @endforelse
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
    <div class="modal fade" id="edit_vacinate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('Modifier une vaccination') }} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="#" id="form_edit_vacinate" method="post">
                        <div class="form-group {{ $errors->has('patient_code') ? 'has-error' : '' }}">
                            <label class="control-label" for="patient_code"> {{ __('Code du patient') }} </label>
                            <input type="text" class="form-control" name="patient_code" required id="patient_code" placeholder="Code du patient">

                            <div class="invalid-feedback">
                                Veuillez saisir le code du patient
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('vaccine_name') ? 'has-error' : '' }}">
                            <label class="control-label" for="vaccine_name"> {{ __('Nom du vaccin') }} </label>
                            <select class="form-control custom-select" required name="vaccine_name" id="vaccine_name">
                                <option value=""> Veuilez choisir un vaccin </option>
                            </select>

                            <div class="invalid-feedback">
                                Veuillez choisir le nom du vaccin
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('date_vaccinate') ? 'has-error' : '' }}">
                            <label class="control-label" for="date_vaccinate"> {{ __('Date de vaccination') }} </label>
                            <input type="date" class="form-control" required name="date_vaccinate" id="date_vaccinate"/>

                            <div class="invalid-feedback">
                                Veuillez choisir une date
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('time_vaccinate') ? 'has-error' : '' }}">
                            <label class="control-label" for="time_vaccinate"> {{ __('Heure de vaccination') }} </label>
                            <input type="time" class="form-control" required name="time_vaccinate" id="time_vaccinate"/>

                            <div class="invalid-feedback">
                                Veuillez choisir l'heure
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('lot_number_vaccine') ? 'has-error' : '' }}">
                            <label class="control-label" for="lot_number_vaccine"> {{ __('Numéro du lot du vaccin') }} </label>
                            <input type="tel" class="form-control" required name="lot_number_vaccine" id="lot_number_vaccine" placeholder="Numéro du lot du vaccin">

                            <div class="invalid-feedback">
                                Veuillez saisir le numéro du vaccin
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('rappelle') ? 'has-error' : '' }}">
                            <label class="control-label" for="rappelle"> {{ __('Temps de rappelle') }} </label>
                            <input type="text" class="form-control" name="rappelle" id="rappelle" placeholder="Temps de rappelle (NP par défaut)">
                        </div>

                        <div class="form-group {{ $errors->has('image_path') ? 'has-error' : '' }}">
                            <label class="control-label" for="image_path"> {{ __('Photo du flacon du vaccin') }} </label>
                            <input type="file" class="form-control" name="image_path" id="image_path" placeholder="Photo du flacon du vaccin">
                        </div>

                        <div class="form-group {{ $errors->has('doctor_name') ? 'has-error' : '' }}">
                            <label class="control-label" for="doctor_name"> {{ __('Nom du docteur ou l\'agent') }} </label>
                            <input type="text" class="form-control" required name="doctor_name" id="doctor_name" placeholder="Nom du docteur ou l'agent">

                            <div class="invalid-feedback">
                                Veuillez saisir le nom de l'agent
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('doctor_phone') ? 'has-error' : '' }}">
                            <label class="control-label" for="doctor_phone"> {{ __('Contact') }} </label>
                            <input type="text" class="form-control" required name="doctor_phone" id="doctor_phone" placeholder="Contact">

                            <div class="invalid-feedback">
                                Veuillez saisir le contact
                            </div>
                        </div>

                        <div class="mt-2 align-center offset-md-4">
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
