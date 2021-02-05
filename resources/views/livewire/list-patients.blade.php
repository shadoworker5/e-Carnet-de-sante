<div>
    <h1 class="text-center"> Liste des patients </h1>
    
    <div class="row mt-4">
        <div class="row">
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" wire:model.defer.defer="code_patient" placeholder="Nom ou code du patient" id="floatingSearch" name="search">
                <label for="floatingSearch"> {{ __("Nom ou code du patient") }} </label>
            </div>

            <div class="form-floating col-md-2">
                <input type="date" class="form-control" wire:model.defer="birthday" placeholder="Date de naissance" id="floatingBirthday" name="birthday">
                <label for="floatingBirthday"> {{ __("Date de naissance") }} </label>
            </div>
            
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" wire:model.defer="born_location" placeholder="Lieu de naissance" id="floatingLocation" name="born_location">
                <label for="floatingLocation"> {{ __("Lieu de naissance") }} </label>
            </div>
            
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" wire:model.defer="name_father" placeholder="Nom du père" id="floatingFather" name="name_father">
                <label for="floatingFather"> {{ __("Nom du père") }} </label>
            </div>
            
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" wire:model.defer="name_mother" placeholder="Nom de la mère" id="floatingMother" name="name_mother">
                <label for="floatingMother"> {{ __("Nom de la mère") }} </label>
            </div>
            
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" wire:model.defer="helper_contact" placeholder="Contact" id="floatingContact" name="helper_contact">
                <label for="floatingContact"> {{ __("Contact") }} </label>
            </div>

            <button class="btn btn-primary mt-2 col-md-2" wire:click="searchPatient">
                <i class="fa fa-search"></i>
                {{ __("Rechercher") }}
            </button>

        </div>
        <div>
            <select class="form-control mt-2" wire:model.lazy="per_page" name="choose" id="choose">
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
                        {{ __('Code') }}
                    </th>

                    <th>
                        {{ __('Nom') }}
                    </th>

                    <th>
                        {{ __('Date de naissance') }}
                    </th>
                    
                    <th>
                        {{ __('Lieu de naissance') }}
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
                @forelse($patients as $patient)
                    <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
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
                            {{ $patient->born_location }}
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
                    @empty
                        <tr>
                            <td colspan="7">
                                <center><p class="text-danger"> Aucune ligne trouvée</p></center>
                            </td>
                        </tr>
                    @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="offset-md-5">
        {{ $patients->links() }}
    </div>
</div>