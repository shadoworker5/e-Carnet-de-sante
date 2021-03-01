@extends('layouts.app', ['title' => 'Information du patient'])

@section('main_content')
    <div class="row">
        <div class="col-md-4">
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th colspan="2"> Info du patient </th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td> {{ __("Code du patient: ") }} </td>
                        <td> {{ $infos->code_patient }} </td>
                    </tr>
                    
                    <tr>
                        <td> {{ __("Nom: ") }} </td>
                        <td> {{ $infos->full_name }} </td>
                    </tr>

                    <tr>
                        <td> {{ __("Date de naissance: ") }} </td>
                        <td> {{ $infos->birthday }} </td>
                    </tr>

                    <tr>
                        <td> {{ __("Nom du père: ") }} </td>                    
                        <td> {{ $infos->name_father }} </td>
                    </tr>

                    <tr>
                        <td> {{ __("Nom de la mère: ") }} </td>
                        <td> {{ $infos->name_mother }} </td>
                    </tr>

                    <tr>
                        <td> {{ __("Personne à prevenir") }} </td>
                        <td> {{ $infos->full_name }} </td>
                    </tr>

                    <tr>
                        <td> {{ __("Contact: ") }} </td>
                        <td> {{ $infos->helper_contact }} </td>
                    </tr>

                    <tr>
                        <td> {{ __("E-mail: ") }} </td>
                        <td> {{ $infos->helper_email }} </td>
                    </tr>
                    @if(Auth::user()->user_role !== 'guest')
                        <tr>
                            <td> {{ __("Action: ") }} </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if(Auth::user()->user_role !== 'collector')
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#info_delete"> {{ __("Supprimer") }} </button>
                                    @endif                
                                    <a href="{{ route('patient.edit', $infos) }}" class="btn btn-primary"> {{ __("Modifier") }} </a>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            
            @if(Auth::user()->user_role !== 'guest')
                <a href="{{ route('add_vacination', $infos->code_patient) }}" id="vacine_patient" data-code="{{ $infos->code_patient }}" class="btn btn-success">
                    Ajouter une vaccination
                </a>
            @endif
        </div>

        <div class="col-md-8">
            <h1 class="text-center"> {{ __("Tableau des vaccinations à jour") }} </h1>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="justify-between">
                        <tr>
                            <th> {{ __('Date de vaccination') }} </th>

                            <th> {{ __('Vaccin') }} </th>
                            
                            <th> {{ __('Etat') }} </th>

                            <th> {{ __('Rappel du vaccin') }} </th>

                            <th> {{ __('Validité') }} </th>

                            <th> {{ __('Action') }} </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($vaccinations as $vacine)
                            <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
                                <td> {{ $vacine->date_vacination }} </td>

                                <td> {{ get_vaccine_name($vacine->vaccine_calendar_id) }} </td>

                                <td> {{ $vacine->vacine_status ? 'A jour' : 'Pas à jour' }} </td>

                                <td> {{ $vacine->rappelle !== null ? $vacine->rappelle : 'NP' }} </td>
                                
                                <td> {!! date('Y-m-d') > $vacine->validity_vacine ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times text-danger"></i>' !!} </td>
                                
                                <td>
                                    <a href="{{ route('vaccinate.show', $vacine->id) }}" class="btn btn-success">
                                        Détail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <p class="text-danger text-center"> Aucune ligne trouvée</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(count($vaccine_updates) !== 0)
                <h1 class="text-center"> {{ __("Tableau des vaccinations non à jour") }} </h1>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> {{ __('Age') }} </th>

                                <th> {{ __('Vaccin') }} </th>
                                
                                <th> {{ __('Description') }} </th>

                                <th> {{ __('Validité') }} </th>
                            </tr>
                        </thead>

                        <tbody class="bg-gray-200">
                            @forelse($vaccine_updates as $update)
                                <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
                                    <td> {{ $update->patient_age }} </td>

                                    <td> {{ $update->name_vaccine }} </td>

                                    <td> {{ $update->illness_against }} </td>
                                    
                                    <td> {{ $update->status ? 'Valide' : 'Invalide' }} </td> 
                                </tr>
                            @empty
                                <p class="text-danger text-center"> Aucune ligne trouvée</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="info_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __("Confirmer la suppression") }} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    {{ __("Etes-vous sûr de vouloir supprimer") }}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> {{ __("Fermer") }} </button>
                    <a href="#" class="btn btn-danger"> {{ __("Supprimer") }} </a>
                </div>
            </div>
        </div>
    </div>
@endsection