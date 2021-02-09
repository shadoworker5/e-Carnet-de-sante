@extends('layouts.app', ['title' => 'Ajouter un vaccin'])

@section('main_content')
    <div class="row">
        <div class="col-md-6 offset-md-3 mb-2">
            <h2 class="text-center"> {{ __('Ajouter dans le calendrier') }} </h2>

            <form action="{{ route('calendar.store') }}" class="needs-validation" novalidate method="post">
                @csrf

                <div class="form-group {{ $errors->has('age') ? 'has-error' : '' }}">
                    <label class="control-label" for="age"> {{ __('Age du patient') }} </label>
                    <input type="text" class="form-control" name="age" id="age" required value="{{ old('age') }}" placeholder="Age du patient">
                    {!! $errors->first('age', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir l'age du patient
                    </div>
                </div>

                <div class="form-group {{ $errors->has('name_vacine') ? 'has-error' : '' }}">
                    <label class="control-label" for="name_vacine"> {{ __('Nom du vaccin') }} </label>
                    <input type="text"  class="form-control" name="name_vacine" required value="{{ old('name_vacine') }}" placeholder="Nom du vaccin" id="name_vacine"/>
                    {!! $errors->first('name_vacine', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir le nom du vaccin
                    </div>
                </div>

                <div class="form-group {{ $errors->has('illness') ? 'has-error' : '' }}">
                    <label class="control-label" for="illness"> {{ __('Maladie luttée') }} </label>
                    <textarea  class="form-control" name="illness" id="illness" style="resize:none" required cols="50" rows="10">{{ old('illness') }}</textarea>
                    {!! $errors->first('illness', '<span class="text-danger">:message</span>') !!}
                    <div class="invalid-feedback">
                        Veuillez saisir une description
                    </div>
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

@section('script_js')
    <script>
        // Validation du formulaire
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        const valide_form = () => {
        
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
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