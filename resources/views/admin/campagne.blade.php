@extends('layouts.app_admin', ['title' => 'Ajouter une campagne'])

@section('main_content')
    <div class="row">
        <div class="col-md-6 mt-3 offset-md-3 mb-2">
            <h2 class="text-center"> {{ __('Ajouter une campagne de vaccination') }}</h2>

            <form action="{{ route('notify') }}" id="form_campagne" class="needs-validation" novalidate method="post">
                @csrf

                <div class="form-group">
                    <label class="control-label" for="date_de_debut"> {{ __('Date de début') }} </label>
                    <input type="date" class="form-control" required name="date_de_debut" value="{{ old('date_de_debut') }}" id="date_de_debut"/>
                    {!! $errors->first('date_de_debut', '<span class="text-danger">:message</span>') !!}

                    <div class="invalid-feedback">
                        Veuillez choisir une date
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="date_de_fin"> {{ __('Date de fin') }} </label>
                    <input type="date" class="form-control" required name="date_de_fin" value="{{ old('date_de_fin') }}" id="date_de_fin"/>
                    {!! $errors->first('date_de_fin', '<span class="text-danger">:message</span>') !!}

                    <div class="invalid-feedback">
                        Veuillez choisir une date
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="intitule_vaccine"> {{ __('Intitulé de la vaccination') }} </label>
                    <input type="text" class="form-control" required name="intitule_vaccine" id="intitule_vaccine" value="{{ old('intitule_vaccine') }}" placeholder="Intitulé de la vaccination">
                    {!! $errors->first('intitule_vaccine', '<span class="text-danger">:message</span>') !!}

                    <div class="invalid-feedback">
                        Veuillez saisir un titre
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="patient_age"> {{ __('Tranche d\'âge') }} </label>
                    <select class="form-control custom-select" required name="patient_age" id="patient_age">
                        <option value=""> Veuilez une tranche d'âge </option>
                        <option value="0-5"> 0 à 5 ans </option>
                        <option value="5-10"> 5 à 10 ans </option>
                        <option value="10-15"> 10 à 15 ans </option>
                        <option value="15-20"> 15 à 20 ans </option>
                        <option value="+20"> +20 ans </option>
                    </select>
                    {!! $errors->first('patient_age', '<span class="text-danger">:message</span>') !!}

                    <div class="invalid-feedback">
                        Veuillez choisir une tranche d'âge
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="location"> {{ __('Zone concerné') }} </label>
                    <select class="form-control custom-select" required name="location" id="location" onchange="showLocation(this.value)">
                        <option value=""> Veuilez une zone </option>
                        <option value="national"> National </option>
                        <option value="regionale"> Régionale </option>
                    </select>
                    {!! $errors->first('location', '<span class="text-danger">:message</span>') !!}

                    <div class="invalid-feedback">
                        Veuillez choisir une zone
                    </div>
                </div>

                @php
                    $list_regions = App\Models\Regions::all();
                @endphp

                <div class="d-none" id="regions">
                    <label class="control-label"> {{ __('Cochez les régions concernées') }} </label> <br>
                    @foreach($list_regions as $regions)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $regions->id }}" id="{{ $regions->title.'_'.$loop->index }}">
                            <label class="form-check-label" for="{{ $regions->title.'_'.$loop->index }}"> {{ $regions->title }} </label> <br>
                        </div>
                    @endforeach
                </div>

                <div class="mt-2 align-center offset-md-4">
                    <button class="btn btn-danger"  onclick="javascript:history.back();">
                        {{ __('Annuler') }}
                    </button>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Envoyé') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/form_validate.js') }}"></script>
    <script>
        function showLocation(value){
            let show = document.getElementById('regions');
            value === 'regionale' ? show.classList.remove('d-none') : show.classList.add('d-none');
        }
    </script>
@endsection
