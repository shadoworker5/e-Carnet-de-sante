@extends('layouts.app', ['title' => 'Information du patient'])

@section('main_content')
    <div class="row">
        <div class="col-md-4 mt-2">
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
                </tbody>
            </table>
        </div>

        <div class="col-md-8 mt-3">
            <h1 class="text-center"> {{ __("Tableau des vaccinations à jour") }} </h1>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="justify-between">
                        <tr>
                            <th> {{ __('Date') }} </th>
                            <th> {{ __('Heure') }} </th>
                            <th> {{ __('Vaccin') }} </th>
                            <th> {{ __('Etat') }} </th>
                            <th> {{ __('Rappel du vaccin') }} </th>
                            <th> {{ __('Capture du flacon') }} </th>
                            <th> {{ __('Validité') }} </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($vaccinations as $vacine)
                            <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
                                <td> {{ $vacine->date_vacination }} </td>
                                <td> {{ format_vaccinate_time($vacine->time_vacination) }} </td>

                                <td> {{ get_vaccine_name($vacine->vaccine_calendar_id) }} </td>

                                <td> {{ $vacine->vacine_status ? 'A jour' : 'Pas à jour' }} </td>

                                <td> {{ $vacine->rappelle !== null ? $vacine->rappelle : 'NP' }} </td>

                                <td>
                                    @if($vacine->path_capture !== null)
                                        <a href="{{ asset("flacon_images/$vacine->path_capture") }}">
                                            <img src="{{ asset("flacon_images/$vacine->path_capture") }}" width="100px" />
                                        </a>
                                    @else
                                        {{ 'NP' }}
                                    @endif
                                </td>

                                <td>
                                    {!! date('Y-m-d') > $vacine->validity_vacine ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times text-danger"></i>' !!}
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

            @if(get_vacine_status_per_patient($infos->id, $infos->birthday))
                <h1 class="text-center"> {{ __("Tableau des vaccinations à venir") }} </h1>
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
@endsection
