@extends(in_array(Auth::user()->user_role, ['root']) ? 'layouts.app' : 'layouts.app', ['title' => 'Liste des patients'])

@section('main_content')
    @livewire('list-patients')
    {{-- <h1 class="text-center"> Liste des patients </h1>
    
    <div class="row mt-4">
        <form action="{{ route('getUserByinfo') }}" method="GET">
            @csrf

            <div class="row">
                <div class="form-floating col-md-2">
                    <input type="text" class="form-control" placeholder="Nom ou code du patient" id="floatingSearch" name="search">
                    <label for="floatingSearch"> {{ __("Nom ou code du patient") }} </label>
                </div>
    
                <div class="form-floating col-md-2">
                    <input type="date" class="form-control" placeholder="Date de naissance" id="floatingBirthday" name="birthday">
                    <label for="floatingBirthday"> {{ __("Date de naissance") }} </label>
                </div>
                
                <div class="form-floating col-md-2">
                    <input type="text" class="form-control" placeholder="Lieu de naissance" id="floatingLocation" name="born_location">
                    <label for="floatingLocation"> {{ __("Lieu de naissance") }} </label>
                </div>
                
                <div class="form-floating col-md-2">
                    <input type="text" class="form-control" placeholder="Nom du père" id="floatingFather" name="name_father">
                    <label for="floatingFather"> {{ __("Nom du père") }} </label>
                </div>
                
                <div class="form-floating col-md-2">
                    <input type="text" class="form-control" placeholder="Nom de la mère" id="floatingMother" name="name_mother">
                    <label for="floatingMother"> {{ __("Nom de la mère") }} </label>
                </div>
                
                <div class="form-floating col-md-2">
                    <input type="text" class="form-control" placeholder="Contact" id="floatingContact" name="helper_contact">
                    <label for="floatingContact"> {{ __("Contact") }} </label>
                </div>
            </div>

            <div class="row mb-2">
                <select class="form-control mt-2 col-md-6 custom-select" name="per_page" id="per_page">
                    @for($i = 5; $i <= 100; $i += 5)
                        <option value="{{ $i }}"> {{ $i }} <option>
                    @endfor
                </select>

                <button class="btn btn-primary mt-2 col-md-4 offset-2">
                    <i class="fa fa-search"></i>
                    {{ __("Rechercher") }}
                </button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
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
                @forelse($patients as $patient)
                    <tr class="{{ $loop->index % 2 == 0 ? 'bg-info text-white' : '' }}">
                        <td> {{ $patient->code_patient }} </td>

                        <td> {{ $patient->full_name }} </td>

                        <td> {{ $patient->birthday }} </td>
                        
                        <td> {{ $patient->born_location }} </td>
                        
                        <td> {{ $patient->name_father.', '.$patient->name_mother }} </td>

                        <td>
                            {!! get_vacine_status_per_patient($patient->id, $patient->birthday) ? '<div class="text-center text-danger"> <i class="fa fa-times fa-2x"></i> </div>' : '<div class="text-center text-success"> <i class="fa fa-check"></i> </div>' !!}
                        </td>
                        
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('patient.show', $patient) }}" class="btn btn-success">
                                    Afficher
                                </a>

                                @if(get_vacine_status_per_patient($patient->id, $patient->birthday)) 
                                    <a href="{{ route('add_vacination', $patient->code_patient) }}" class="btn btn-warning">
                                        Ajouter vacciner
                                    </a>
                                @endif
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
    --}}
    
@endsection