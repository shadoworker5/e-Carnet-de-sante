@extends('layouts.app', ['title' => 'Modifier un vaccin'])

@section('main_content')
    <div class="row">
        <div class="col-md-6 offset-md-3 mb-2">
            <h2 class="text-center"> {{ __('Modifier la vaccination') }}</h2>
            <form action="{{ route('calendar.update', $vacine) }}" class="needs-validation" novalidate method="post">
                @csrf
                {{ method_field('PUT') }}

                <div class="form-group {{ $errors->has('age') ? 'has-error' : '' }}">
                    <label class="control-label" for="age"> {{ __('Age du patient') }} </label>
                    <input type="text" class="form-control" name="age" id="age" required value="{{ old('age') ?? $vacine->patient_age }}" placeholder="Age du patient">
                    {!! $errors->first('age', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir l'âge du patient
                    </div>
                </div>

                <div class="form-group {{ $errors->has('name_vacine') ? 'has-error' : '' }}">
                    <label class="control-label" for="name_vacine"> {{ __('Nom du vaccin') }} </label>
                    <input type="text"  class="form-control" name="name_vacine" required value="{{ old('name_vacine') ?? $vacine->name_vaccine }}" placeholder="Nom du vaccin" id="name_vacine"/>
                    {!! $errors->first('name_vacine', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir le nom du vaccin
                    </div>
                </div>

                <div class="form-group {{ $errors->has('name_vacine') ? 'has-error' : '' }}">
                    <label class="control-label" for="vacine_status"> {{ __('Etat du vaccin') }} </label>
                    <select name="vacine_status" required class="form-control" id="vacine_status">
                        <option value=""> Choisir un état </option>
                        <option value="1" {{ old('vacine_status') == "1" ? 'selected' : '' }}> Valide </option>
                        <option value="0" {{ old('vacine_status') == "0" ? 'selected' : '' }}> Non valide </option>
                    </select>

                    {!! $errors->first('vacine_status', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez choisir l'état du vaccin
                    </div>
                </div>

                <div class="form-group {{ $errors->has('illness') ? 'has-error' : '' }}">
                    <label class="control-label" for="illness"> {{ __('Maladie luttée') }} </label>
                    <textarea  class="form-control" name="illness" id="illness" required style="resize:none" cols="50" rows="10">{{ old('illness') ?? $vacine->illness_against }}</textarea>
                    {!! $errors->first('illness', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir le description du vaccin
                    </div>
                </div>

                <div class="mt-2 offset-md-4">
                    <a href="#" onclick="javascript:history.back();" class="btn btn-danger">
                        {{ __('Annuler') }}
                    </a>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Ajouter') }}
                    </button>
                </div>
            </form>
        </div>
    </div>  
@endsection

@section('script_js')
    <script>
        const valide_form = () => {
        
        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
            })
        }
        valide_form();
    </script>
@endsection