<div>
    <br>
    <h1 class="text-center mt-3"> Liste des patients </h1>

    <div class="row mt-4">
        <div class="row">
            <div class="form-floating col-md-2">
                <input type="text" class="form-control" wire:model="code_patient" placeholder="Nom ou code du patient" id="floatingSearch" name="search">
                <label for="floatingSearch"> {{ __("Nom ou code") }} </label>
            </div>

            <div class="form-floating col-md-2">
                <input type="date" class="form-control" wire:model="birthday" placeholder="Date de naissance" id="floatingBirthday" name="birthday">
                <label for="floatingBirthday"> {{ __("Date de naissance") }} </label>
            </div>

            <div class="form-floating col-md-2">
                <input type="text" class="form-control" wire:model="born_location" placeholder="Lieu de naissance" id="floatingLocation" name="born_location">
                <label for="floatingLocation"> {{ __("Lieu de naissance") }} </label>
            </div>

            <div class="form-floating col-md-2">
                <input type="text" class="form-control" wire:model="name_father" placeholder="Nom du père" id="floatingFather" name="name_father">
                <label for="floatingFather"> {{ __("Nom du père") }} </label>
            </div>

            <div class="form-floating col-md-2">
                <input type="text" class="form-control" wire:model="name_mother" placeholder="Nom de la mère" id="floatingMother" name="name_mother">
                <label for="floatingMother"> {{ __("Nom de la mère") }} </label>
            </div>

            <div class="form-floating col-md-2">
                <input type="text" class="form-control" wire:model="helper_contact" placeholder="Contact" id="floatingContact" name="helper_contact">
                <label for="floatingContact"> {{ __("Contact") }} </label>
            </div>
        </div>

        <div class="row mb-2 mt-2">
            {{-- <select class="form-control col-md-6 custom-select" wire:model.lazy="per_page" name="choose" id="choose">
                @for($i = 5; $i <= 100; $i += 5)
                <option value="{{ $i }}"> {{ $i }} <option>
                    @endfor
            </select> --}}
            <div class="text-center">
                <button class="btn bg_color col-md-4 text-white" style="border-radius:20px" wire:click="searchPatient">
                    <i class="fa fa-search"></i>
                    {{ __("Rechercher") }}
                </button>
            </div>
        </div>

    </div>

    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> {{ __('Code') }} </th>

                    <th> {{ __('Nom') }} </th>

                    <th> {{ __('Date de naissance') }} </th>

                    <th> {{ __('Lieu de naissance') }} </th>

                    <th> {{ __('Nom des parents') }} </th>

                    <th> {{ __('Etat de vaccination') }} </th>

                    <th> {{ __('Action') }} </th>
                </tr>
            </thead>

            <tbody>
                @foreach($patients as $patient )
                    <tr>
                        <td> {{ $patient->code_patient }} </td>

                        <td> {{ $patient->full_name }} </td>

                        <td> {{ $patient->birthday }} </td>

                        <td> {{ $patient->born_location }} </td>

                        <td> {{ $patient->name_father.', '.$patient->name_mother }} </td>

                        <td>
                            {!! get_vacine_status_per_patient($patient->id, $patient->birthday) ? '<div class="text-center"> <i class="fa fa-times fa-2x text-danger"></i> </div>' : '<div class="text-center"> <i class="fa fa-check fa-2x text-success"></i> </div>' !!}
                        </td>

                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('patient.show', $patient->id) }}" class="btn bg_color text-white">
                                    <i class="fa fa-eye"></i>
                                </a>

                                @if(get_vacine_status_per_patient($patient->id, $patient->birthday))
                                    <a href="{{ route('add_vacination', $patient->code_patient) }}" class="btn btn_color text-white">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                {{-- @empty
                    <tr>
                        <td colspan="7">
                            <p class="text-danger text-center"> Aucune ligne trouvée</p>
                        </td>
                    </tr> --}}
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="offset-md-5">
        {{-- {{ $patients->links() }} --}}
    </div>
</div>
