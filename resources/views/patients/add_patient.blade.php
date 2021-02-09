@extends('layouts.app', ['title' => 'Ajouter un patient'])

@section('main_content')
    <div class="row">
        <div class="col-md-6 offset-md-3 mb-2">
            <h2 class="text-center"> {{ __('Formulaire patient') }}</h2>

            <form action="{{ route('patient.store') }}" class="needs-validation" novalidate method="post">
                @csrf

                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label class="control-label" for="name"> {{ __('Nom complet') }} </label>
                    <input type="text" class="form-control" required name="name" id="name" value="{{ old('name') }}" placeholder="Nom complet">
                    {!! $errors->first('name', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir le nom du patient
                    </div>
                </div>

                <div class="form-group {{ $errors->has('birthday') ? 'has-error' : '' }}">
                    <label class="control-label" for="birthday"> {{ __('Date de naissance') }} </label>
                    <input type="date" class="form-control" name="birthday" value="{{ old('birthday') }}" required id="birthday"/>
                    {!! $errors->first('birthday', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez choisir la date de naissance
                    </div>
                </div>

                <div class="form-group {{ $errors->has('born_location') ? 'has-error' : '' }}">
                    <label class="control-label" for="born_location"> {{ __('Lieu de naissance') }} </label>
                    <input type="text" class="form-control" name="born_location" id="born_location" required value="{{ old('born_location') }}" placeholder="Lieu de naissance">
                    {!! $errors->first('born_location', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir le ieu de naissance
                    </div>
                </div>

                <div class="form-group {{ $errors->has('father_name') ? 'has-error' : '' }}">
                    <label class="control-label" for="father_name"> {{ __('Nom du père') }} </label>
                    <input type="text" class="form-control" name="father_name" id="father_name" required value="{{ old('father_name') }}" placeholder="Nom du père">
                    {!! $errors->first('father_name', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir le nom du père
                    </div>
                </div>
                    
                <div class="form-group {{ $errors->has('mother_name') ? 'has-error' : '' }}">
                    <label class="control-label" for="mother_name"> {{ __('Nom de la mère') }} </label>
                    <input type="text" class="form-control" name="mother_name" required id="mother_name" value="{{ old('mother_name') }}" placeholder="Nom de la mère">
                    {!! $errors->first('mother_name', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir le nom de mère
                    </div>
                </div>
                    
                <div class="form-group {{ $errors->has('mentor_name') ? 'has-error' : '' }}">
                    <label class="control-label" for="mentor_name"> {{ __('Personne à prévenir en cas de besoin') }} </label>
                    <input type="text" class="form-control" name="mentor_name" required id="mentor_name" value="{{ old('mentor_name') }}" placeholder="Nom du personne à prévenir">
                    {!! $errors->first('mentor_name', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir le nom du personne à prévenir
                    </div>
                </div>
                    
                <div class="form-group {{ $errors->has('helper_contact') ? 'has-error' : '' }}">
                    <label class="control-label" for="helper_contact"> {{ __('Contact en cas de besoin') }} </label>
                    <input type="text" class="form-control" required name="helper_contact" id="helper_contact" value="{{ old('helper_contact') }}" placeholder="Contact en cas de besoin">
                    {!! $errors->first('helper_contact', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir le contact
                    </div>
                </div>
                    
                <div class="form-group {{ $errors->has('helper_email') ? 'has-error' : '' }}">
                    <label class="control-label" for="helper_email"> {{ __('E-mail (facultatif)') }} </label>
                    <input type="text" class="form-control" name="helper_email" id="helper_email" value="{{ old('helper_email') }}" placeholder="E-mail (NP par défaut)">
                    {!! $errors->first('helper_email', '<span class="text-danger">:message</span>') !!}
                </div>

                <div class="mt-2 align-center offset-md-4">
                    <button class="btn btn-danger">
                        {{ __('Annuler') }}
                    </button>

                    <button type="submit" id="submit_add_patient" class="btn btn-primary">
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