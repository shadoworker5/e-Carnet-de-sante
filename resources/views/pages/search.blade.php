@extends('layouts.app', ['title' => 'Votre eCarnet'])

@section('main_content')
    <div class="row">
        <div class="col-md-6 mt-3 offset-md-3 mb-2">
            <h2 class="text-center"> {{ __('Voir votre eCarnet') }}</h2>

            @include('layouts.partials.flash_msg')

            <form action="{{ route('response') }}" method="post">
                @csrf

                <div class="form-group">
                    <label class="control-label" for="code_patient"> {{ __('Code patient') }} </label>
                    <input type="text" class="form-control" name="code_patient" id="code_patient" placeholder="Code patient">
                </div>

                <div class="form-group">
                    <label class="control-label" for="full_name"> {{ __('Nom complet') }} </label>
                    <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Nom complet">
                </div>

                <div class="form-group">
                    <label class="control-label" for="birthday"> {{ __('Date de naissance') }} </label>
                    <input type="date" class="form-control" name="birthday" id="birthday"/>
                </div>

                <div class="form-group">
                    <label class="control-label" for="born_location"> {{ __('Lieu de naissance') }} </label>
                    <input type="text" class="form-control" name="born_location" id="born_location" placeholder="Lieu de naissance">
                </div>

                <div class="form-group">
                    <label class="control-label" for="name_father"> {{ __('Nom du père') }} </label>
                    <input type="text" class="form-control" name="name_father" id="name_father" placeholder="Nom du père">
                </div>

                <div class="form-group">
                    <label class="control-label" for="name_mother"> {{ __('Nom de la mère') }} </label>
                    <input type="text" class="form-control" name="name_mother" id="name_mother" placeholder="Nom de la mère">
                </div>

                <div class="mt-2 align-center offset-md-4">
                    <button class="btn btn-danger" onclick="javascript:history.back();">
                        {{ __('Annuler') }}
                    </button>

                    <button type="submit" id="submit_add_patient" class="btn btn-primary">
                        {{ __('Afficher') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script_js')
    <script>
        document.getElementById('region_id').removeAttribute('required')
    </script>
@endsection
