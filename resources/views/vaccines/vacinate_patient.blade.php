@extends('layouts.app', ['title' => 'Ajouter une vaccination'])

@section('main_content')
    <div class="row">
        <div class="col-md-6 mt-3 offset-md-3 mb-2">
            <h2 class="text-center"> {{ __('Ajouter une vaccination') }}</h2>
            
            <form action="{{ route('vaccinate.store') }}" id="form_vacinate" class="needs-validation" novalidate method="post">
                @csrf

                <div class="form-group">
                    <label class="control-label" for="patient_code"> {{ __('Code du patient') }} </label>
                    <input type="text" class="form-control" name="patient_code" required id="patient_code" value="{{ old('patient_code') ?? ($patient_code ?? '') }}" @if(isset($patient_code)){{ 'readonly' }} @endif placeholder="Code du patient">
                    {!! $errors->first('patient_code', '<span class="text-danger">:message</span>') !!}

                    <div class="invalid-feedback">
                        Veuillez saisir le code du patient
                    </div>
                </div>
                
                <div class="form-group d-none" id="patient_name">
                    <label class="control-label" for="patient_info"> {{ __('Nom complet du patient') }} </label>
                    <input type="text" name="patient_info" class="form-control" id="patient_info" readonly>
                </div>                    
            
                <div class="form-group {{ $errors->has('vaccine_name') ? 'has-error' : '' }}">
                    <label class="control-label" for="vaccine_name"> {{ __('Nom du vaccin') }} </label>
                    <select class="form-control custom-select" required name="vaccine_name" id="vaccine_name">
                        <option value=""> Veuilez choisir un vaccin </option>
                        @foreach($vaccines as $vaccine)
                            <option value="{{ $vaccine->id }}" {{ old('vaccine_name') == $vaccine->id ? "selected" : "" }}> {{ $vaccine->name_vaccine }} </option>
                        @endforeach
                    </select>
                    {!! $errors->first('vaccine_name', '<span class="text-danger">:message</span>') !!}

                    <div class="invalid-feedback">
                        Veuillez choisir le nom du vaccin
                    </div>
                </div>

                <div class="form-group {{ $errors->has('date_vaccinate') ? 'has-error' : '' }}">
                    <label class="control-label" for="date_vaccinate"> {{ __('Date de vaccination') }} </label>
                    <input type="date" class="form-control" required name="date_vaccinate" value="{{ old('date_vaccinate') }}" id="date_vaccinate"/>
                    {!! $errors->first('date_vaccinate', '<span class="text-danger">:message</span>') !!}

                    <div class="invalid-feedback">
                        Veuillez choisir une date
                    </div>
                </div>

                <div class="form-group {{ $errors->has('time_vaccinate') ? 'has-error' : '' }}">
                    <label class="control-label" for="time_vaccinate"> {{ __('Heure de vaccination') }} </label>
                    <input type="time" class="form-control" required name="time_vaccinate" value="{{ old('time_vaccinate') }}" id="time_vaccinate"/>
                    {!! $errors->first('time_vaccinate', '<span class="text-danger">:message</span>') !!}

                    <div class="invalid-feedback">
                        Veuillez choisir l'heure
                    </div>
                </div>
                
                <div class="form-group {{ $errors->has('lot_number_vaccine') ? 'has-error' : '' }}">
                    <label class="control-label" for="lot_number_vaccine"> {{ __('Numéro du lot du vaccin') }} </label>
                    <input type="tel" class="form-control" required name="lot_number_vaccine" id="lot_number_vaccine" value="{{ old('lot_number_vaccine') }}" placeholder="Numéro du lot du vaccin">
                    {!! $errors->first('lot_number_vaccine', '<span class="text-danger">:message</span>') !!}

                    <div class="invalid-feedback">
                        Veuillez saisir le numéro du vaccin
                    </div>
                </div>
                    
                <div class="form-group {{ $errors->has('rappelle') ? 'has-error' : '' }}">
                    <label class="control-label" for="rappelle"> {{ __('Temps de rappel') }} </label>
                    <input type="text" class="form-control" name="rappelle" id="rappelle" value="{{ old('rappelle') }}" placeholder="Temps de rappel (NP par défaut)">
                    {!! $errors->first('rappelle', '<span class="text-danger">:message</span>') !!}
                </div>                                

                <div class="form-group {{ $errors->has('image_path') ? 'has-error' : '' }}">
                    <label class="control-label" for="image_path"> {{ __('Photo du flacon du vaccin') }} </label>
                    <input type="file" class="form-control" name="image_path" id="image_path" value="{{ old('image_path') }}" placeholder="Photo du flacon du vaccin">
                    {!! $errors->first('image_path', '<span class="text-danger">:message</span>') !!}
                </div>

                <div class="form-group {{ $errors->has('doctor_name') ? 'has-error' : '' }}">
                    <label class="control-label" for="doctor_name"> {{ __('Nom du docteur ou l\'agent') }} </label>
                    <input type="text" class="form-control" required name="doctor_name" id="doctor_name" value="{{ old('doctor_name') }}" placeholder="Nom du docteur ou l'agent">
                    {!! $errors->first('doctor_name', '<span class="text-danger">:message</span>') !!}

                    <div class="invalid-feedback">
                        Veuillez saisir le nom de l'agent
                    </div>
                </div>

                <div class="form-group {{ $errors->has('doctor_phone') ? 'has-error' : '' }}">
                    <label class="control-label" for="doctor_phone"> {{ __('Contact') }} </label>
                    <input type="text" class="form-control" required name="doctor_phone" id="doctor_phone" value="{{ old('doctor_phone') }}" placeholder="Contact">
                    {!! $errors->first('doctor_phone', '<span class="text-danger">:message</span>') !!}
                    
                    <div class="invalid-feedback">
                        Veuillez saisir le contact
                    </div>
                </div>

                <div class="mt-2 align-center offset-md-4">
                    <button class="btn btn-danger"  onclick="javascript:history.back();">
                        {{ __('Annuler') }}
                    </button>

                    <button type="submit" id="submit_vacinate_patient" class="btn btn-primary">
                        {{ __('Ajouter') }}
                    </button>
                </div>
            </form>
        </div>        
    </div>
@endsection

@section('script_js')
    <script src="{{ asset('js/form_validate.js') }}"></script>
@endsection