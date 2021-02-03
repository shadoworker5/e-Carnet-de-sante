@extends('layouts.app', ['title' => 'Information du vaccin'])

@section('main_content')
    <div class="row">
        <div class="mt-5 col-md-4">
            <a href="#" onclick="javascript:history.back();" class="btn btn-primary"> Revenir en arrière </a>
        </div>

        <div class="col-md-8">
            <div>
                {{-- <h1 class="text-center"> {{ __("Tableau des vaccinations à jour") }} </h1> --}}
                <table class="table table-striped">
                    <thead>
                        <th class="text-center">
                            <td colspan="2"> Info du vaccination </td>
                        </th>
                    </thead>

                    <tbody>
                        <tr>
                            <td> {{ __("Code du patient: ") }} </td>
                            <td> {{ $patient_code }} </td>
                        </tr>
                        
                        <tr>
                            <td> {{ __("Numéro du lot du vaccin: ") }} </td>
                            <td> {{ $vaccine_info->lot_number_vacine }} </td>
                        </tr>
                        
                        <tr>
                            <td> {{ __("Date de vaccination: ") }} </td>
                            <td> {{ $vaccine_info->date_vacination }} </td>
                        </tr>

                        <tr>
                            <td> {{ __("Heure de vaccination: ") }} </td>
                            <td> {{ $vaccine_info->time_vacination }} </td>
                        </tr>
                        
                        <tr>
                            <td> {{ __("Validité de la vaccination: ") }} </td>
                            <td> {{ date('Y-m-d') > $vaccine_info->validity_vacine ? 'Valide' : 'Invalide' }} </td>
                        </tr>

                        <tr>
                            <td> {{ __("Rappelle: ") }} </td>                    
                            <td> {{ $vaccine_info->rappelle }} </td>
                        </tr>

                        @if($vaccine_info->path_capture !== null)
                            <tr>
                                <td> {{ __("Capture du flacon du vaccin: ") }} </td>
                                <td> {{ $vaccine_info->path_capture }} </td>
                            </tr>
                        @endif

                        <tr>
                            <td> {{ __("Nom du vaccinateur") }} </td>
                            <td> {{ $vaccine_info->name_doctor }} </td>
                        </tr>

                        <tr>
                            <td> {{ __("Contact: ") }} </td>
                            <td> {{ $vaccine_info->doctor_contact }} </td>
                        </tr>
                        
                        @if($vaccine_info->others_field !== null)
                            <tr>
                                <td> {{ __("Autre: ") }} </td>
                                <td> {{ $vaccine_info->others_field }} </td>
                            </tr>
                        @endif

                        <tr>
                            <td> {{ __("Action ") }} </td>
                            
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#info_delete">
                                        {{ __('Supprimer') }}
                                    </a>
                                    
                                    <a href="{{ route('vaccinate.edit', $vaccine_info) }}" class="btn btn-primary">
                                        {{ __('Modifier') }}
                                    </a>
                                </div>                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="info_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __("Détail sur la vaccination") }} </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
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