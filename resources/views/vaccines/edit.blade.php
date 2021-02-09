@extends('layouts.app', ['title' => 'Modifier une vaccination'])

@section('main_content')
    <div class="row">
        <div class="col-md-6 offset-md-3 mb-2">
            <h2 class="text-center"> {{ __('Modifier une vaccination') }}</h2>
            
            <form action="{{ route('vaccinate.update', $vaccine_info->id) }}" method="POST">
                @csrf
                {{ method_field('PUT') }}

                <div class="form-group {{ $errors->has('patient_code') ? 'has-error' : '' }}">
                    <label class="control-label" for="patient_code"> {{ __('Code du patient') }} </label>
                    <input type="text" class="form-control" readonly="true" name="patient_code" id="patient_code" value="{{ old('patient_code') ?? $patient_code }}" placeholder="Code du patient">
                    {!! $errors->first('patient_code', '<span class="text-danger">:message</span>') !!}
                </div>

                <div class="form-group {{ $errors->has('vaccine_name') ? 'has-error' : '' }}">
                    <label class="control-label" for="vaccine_name"> {{ __('Nom du vaccin') }} </label>
                    <select class="form-control custom-select" name="vaccine_name" id="vaccine_name">
                        <option value=""> Veuilez choisir un vaccin </option>
                        @foreach($vaccines as $vaccine)
                            <option value="{{ $vaccine->id }}" {{ old('vaccine_name') === $vaccine->id || $vaccine_info->vaccine_calendar_id === $vaccine->id ? "selected" : "" }}>
                                {{ $vaccine->name_vaccine }}
                            </option>
                        @endforeach
                    </select>
                    {!! $errors->first('vaccine_name', '<span class="text-danger">:message</span>') !!}
                </div>

                <div class="form-group {{ $errors->has('date_vaccinate') ? 'has-error' : '' }}">
                    <label class="control-label" for="date_vaccinate"> {{ __('Date de vaccination') }} </label>
                    <input type="date" class="form-control" name="date_vaccinate" value="{{ old('date_vaccinate') ?? $vaccine_info->date_vacination }}" id="date_vaccinate"/>
                    {!! $errors->first('date_vaccinate', '<span class="text-danger">:message</span>') !!}
                </div>

                <div class="form-group {{ $errors->has('time_vaccinate') ? 'has-error' : '' }}">
                    <label class="control-label" for="time_vaccinate"> {{ __('Heure de vaccination') }} </label>
                    <input type="time" class="form-control" name="time_vaccinate" value="{{ old('time_vaccinate') ?? $vaccine_info->time_vacination }}" id="time_vaccinate"/>
                    {!! $errors->first('time_vaccinate', '<span class="text-danger">:message</span>') !!}
                </div>

                <div class="form-group {{ $errors->has('doctor_name') ? 'has-error' : '' }}">
                    <label class="control-label" for="doctor_name"> {{ __('Nom du docteur ou l\'agent') }} </label>
                    <input type="text" class="form-control" name="doctor_name" id="doctor_name" value="{{ old('doctor_name') ?? $vaccine_info->name_doctor }}" placeholder="Nom du docteur ou l'agent">
                    {!! $errors->first('doctor_name', '<span class="text-danger">:message</span>') !!}
                </div>
                
                <div class="form-group {{ $errors->has('doctor_phone') ? 'has-error' : '' }}">
                    <label class="control-label" for="doctor_phone"> {{ __('Contact') }} </label>
                    <input type="text" class="form-control" name="doctor_phone" id="doctor_phone" value="{{ old('doctor_phone') ?? $vaccine_info->doctor_contact }}" placeholder="Contact">
                    {!! $errors->first('doctor_phone', '<span class="text-danger">:message</span>') !!}
                </div>
                
                <div class="form-group {{ $errors->has('lot_number_vaccine') ? 'has-error' : '' }}">
                    <label class="control-label" for="lot_number_vaccine"> {{ __('Numéro du lot du vaccin') }} </label>
                    <input type="tel" class="form-control" name="lot_number_vaccine" id="lot_number_vaccine" value="{{ old('lot_number_vaccine') ?? $vaccine_info->lot_number_vacine }}" placeholder="Numéro du lot du vaccin">
                    {!! $errors->first('lot_number_vaccine', '<span class="text-danger">:message</span>') !!}
                </div>
                    
                <div class="form-group {{ $errors->has('rappelle') ? 'has-error' : '' }}">
                    <label class="control-label" for="rappelle"> {{ __('Temps de rappelle') }} </label>
                    <input type="text" class="form-control" name="rappelle" id="rappelle" value="{{ old('rappelle') ?? ($vaccine_info->rappelle == null ? '' : $vaccine_info->rappelle) }}" placeholder="Temps de rappelle (NP par défaut)">
                    {!! $errors->first('rappelle', '<span class="text-danger">:message</span>') !!}
                </div>                                

                <div class="form-group {{ $errors->has('image_path') ? 'has-error' : '' }}">
                    <label class="control-label" for="image_path"> {{ __('Photo du flacon du vaccin') }} </label>
                    <input type="file" class="form-control" name="image_path" id="image_path" value="{{ old('image_path') }}" placeholder="Photo du flacon du vaccin">
                    {!! $errors->first('image_path', '<span class="text-danger">:message</span>') !!}
                </div>

                <div class="mt-2 align-center offset-md-4">
                    <button class="btn btn-danger">
                        {{ __('Annuler') }}
                    </button>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Ajouter') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection