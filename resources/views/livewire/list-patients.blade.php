<div>
    <h1 class="text-center"> Liste des patients </h1>
    
    <div class="row mt-4">
        <div class="col-md-10">
            <label for="search" class="sr-only"> Rechercher </label>
            <input type="text" placeholder="Nom ou code" wire:model="search" id="search" name="search"/>
        </div>

        <div class="col-auto ml-auto mb-2">
            <select class="custom-select w-auto" wire:model.lazy="per_page" name="choose" id="choose">
                @for($i = 5; $i <= 100; $i += 5)
                    <option value="{{ $i }}"> {{ $i }} <option>
                @endfor
            </select>
            <label for="per_page"> {{ __('par page') }} </label>
        </div>
    </div>

    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>
                        {{ __('#Index') }}
                    </th>

                    <th>
                        {{ __('Code') }}
                    </th>

                    <th>
                        {{ __('Nom') }}
                    </th>

                    <th>
                        {{ __('Date de naissance') }}
                    </th>
                    
                    <th>
                        {{ __('Nom des parents') }}
                    </th>

                    <th>
                        {{ __('Etat de vaccination') }}
                    </th>

                    <th>
                        {{ __('Action') }}
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach($patients as $patient)
                    <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
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
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div>
        {{ $patients->links() }}
    </div>
</div>