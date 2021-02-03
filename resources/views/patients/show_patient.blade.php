@extends('layouts.app', ['title' => 'Information du patient'])

@section('main_content')
    <div class="row">
        <div class="col-md-4">
            <table class="table table-striped">
                <thead>
                    <th class="text-center">
                        <td colspan="2"> Info du patient </td>
                    </th>
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
                        <td> {{ __("Nom: ") }} </td>
                        <td> {{ $infos->helper_email }} </td>
                    </tr>
                </tbody>
            </table>
            
            @if(get_vacine_status_per_patient($infos->id) !== "A jour")
                <a href="{{ route('vaccinate.create') }}" class="btn btn-success">
                    Ajouter une vaccination
                </a>
            @endif
        </div>

        <div class="col-md-8">
            <div class="table-responsive-sm">
                <div>
                    <h1 class="text-center"> {{ __("Tableau des vaccinations à jour") }} </h1>
                    <table class="table table-striped">
                        <thead class="justify-between">
                            <tr>
                                <th>
                                    {{ __('Date de vaccination') }}
                                </th>

                                <th>
                                    {{ __('Vaccin') }}
                                </th>
                                
                                <th>
                                    {{ __('Etat') }}
                                </th>

                                <th>
                                    {{ __('Rappel du vaccin') }}
                                </th>

                                <th>
                                    {{ __('Validité') }}
                                </th>

                                <th>
                                    {{ __('Action') }}
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($vaccinations as $vacine)
                                <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
                                    <td>
                                        {{ $vacine->date_vacination }}
                                    </td>

                                    <td>
                                        {{ get_vaccine_name($vacine->vaccine_calendar_id) }}
                                    </td>

                                    <td>
                                        {{ $vacine->vacine_status ? 'A jour' : 'Pas à jour' }}
                                    </td>

                                    <td>
                                        {{ $vacine->rappelle  }}
                                    </td>
                                    
                                    <td>
                                        {{ date('Y-m-d') > $vacine->validity_vacine ? 'Valide' : 'Invalide' }}
                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('vaccinate.show', $vacine->id) }}" class="btn btn-success">
                                            Détail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <center><p class="text-danger"> Aucune ligne trouvée</p></center>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    @if(count($vaccine_updates) !== 0)
                        <h1 class="text-center"> {{ __("Tableau des vaccinations non à jour") }} </h1>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('Age') }}
                                    </th>

                                    <th>
                                        {{ __('Vaccin') }}
                                    </th>
                                    
                                    <th>
                                        {{ __('Description') }}
                                    </th>

                                    <th>
                                        {{ __('Validité') }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-gray-200">
                                @forelse($vaccine_updates as $update)
                                    <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
                                        <td>
                                            {{ $update->patient_age }}
                                        </td>

                                        <td>
                                            {{ $update->name_vaccine }}
                                        </td>

                                        <td>
                                            {{ $update->illness_against }}
                                        </td>
                                        
                                        <td>
                                            {{ $update->status ? 'Valide' : 'Invalide' }} 
                                        </td> 
                                    </tr>
                                @empty
                                    <center><p class="text-danger"> Aucune ligne trouvée</p></center>
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="info_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __("Détail sur la vaccination") }} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td> {{ __("Numéro du lot du vaccin: ") }} </td>
                                <td> {{ $infos->code_patient }} </td>
                            </tr>
                            
                            <tr>
                                <td> {{ __("Date de vaccination: ") }} </td>
                                <td> {{ $infos->full_name }} </td>
                            </tr>

                            <tr>
                                <td> {{ __("Heure de vaccination: ") }} </td>
                                <td> {{ $infos->birthday }} </td>
                            </tr>

                            <tr>
                                <td> {{ __("Date de rappelle: ") }} </td>                    
                                <td> {{ $infos->name_father }} </td>
                            </tr>

                            <tr>
                                <td> {{ __("Capture du flacon du vaccin: ") }} </td>
                                <td> {{ $infos->name_mother }} </td>
                            </tr>

                            <tr>
                                <td> {{ __("Nom du vaccinateur") }} </td>
                                <td> {{ $infos->full_name }} </td>
                            </tr>

                            <tr>
                                <td> {{ __("Contact: ") }} </td>
                                <td> {{ $infos->helper_contact }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> {{ __("Fermer") }} </button>
                    <a href="#" class="btn btn-primary"> {{ __("Modifier") }} </a>
                </div>
            </div>
        </div>
    </div>
@endsection