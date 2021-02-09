@extends('layouts.app', ['title' => 'Liste des vaccinations'])

@section('main_content')
    <div class="row mb-2">
        <h1 class="text-center"> Liste des vaccinations </h1>
        
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
                        <th>
                            {{ __('#Index') }}
                        </th>

                        <th>
                            {{ __('Code patient') }}
                        </th>

                        <th>
                            {{ __('Vaccin') }}
                        </th>

                        <th>
                            {{ __('Date') }}
                        </th>
                        
                        <th>
                            {{ __('Heure') }}
                        </th>
                        
                        <th>
                            {{ __('Numéro du vaccin') }}
                        </th>
                        
                        <th>
                            {{ __('Rappelle') }}
                        </th>

                        <th>
                            {{ __('Nom de l\'agent') }}
                        </th>
                        
                        <th>
                            {{ __('Contact') }}
                        </th>

                        <th>
                            {{ __('Action') }}
                        </th>
                    </tr>
                </thead>

                <tbody id="list_patient">
                    @forelse($submissions as $submission)
                        <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
                            <td>
                                {{ ++$loop->index }}
                            </td>

                            <td>
                                {{ getPatientName($submission->patient_id) }}
                            </td>

                            <td>
                                {{ get_vaccine_name($submission->vaccine_calendar_id) }}
                            </td>
                            
                            <td>
                                {{ $submission->date_vacination }}
                            </td>
                            
                            <td>
                                {{ $submission->time_vacination }}
                            </td>

                            <td>
                                {{ $submission->lot_number_vacine }}
                            </td>

                            <td>
                                {{ $submission->rappelle !== null ? $submission->rappelle : 'NP' }}
                            </td>

                            <td>
                                {{ $submission->name_doctor }}
                            </td>

                            <td>
                                {{ $submission->doctor_contact }}
                            </td>
                            
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('vaccinate.edit', $submission) }}" id="btn_edit_vacinate" class="btn btn-success">
                                        {{ __("Modifier") }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <center><p class="text-danger"> Aucune ligne trouvée</p></center>
                            </td>
                        </tr>
                    @endforelse
                    {{-- <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
                        <td>
                            {{ $loop->index + 1 }}
                        </td>

                        <td>
                            {{ $patient->code_patient }}
                        </td>

                        <td>
                            {{ $patient->full_name }}
                        </td>

                        <td>
                            {{ $patient->birthday }}
                        </td>
                        
                        <td>
                            {{ $patient->name_father.', '.$patient->name_mother }}
                        </td>

                        <td>
                            {{ get_vacine_status_per_patient($patient->id) }}
                        </td>
                        
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('patient.show', $patient) }}" class="btn btn-success">
                                    Afficher
                                </a>

                                @if(get_vacine_status_per_patient($patient->id) !== 'A jour')
                                    <a href="{{ route('vaccinate.create') }}" class="btn btn-warning">
                                        Vacciner
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>

        <div class="col-md-2">
            <a href="#" onclick="javascript:history.back();" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i>
                Revenir en arrière
            </a>
        </div>
    </div>
@endsection