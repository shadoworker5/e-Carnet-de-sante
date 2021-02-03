@extends('layouts.app', ['title' => 'Modifier un vaccin'])

@section('main_content')
    <div class="row">
        {{ $calendar }}
        <div class="col-md-6 offset-md-3">
            <h2 class="text-center"> {{ __('Modifier dans le calendrier') }}</h2>
            <form action="{{ route('calendar.store') }}" method="post">
                @csrf
                {{ method_field('PUT') }}

                <div class="form-group {{ $errors->has('age') ? 'has-error' : '' }}">
                    <label class="control-label" for="age"> {{ __('Age du patient') }} </label>
                    <input type="text" class="form-control" name="age" id="age" value="{{ old('age') }}" placeholder="Age du patient">
                    {!! $errors->first('age', '<span class="text-danger">:message</span>') !!}
                </div>

                <div class="form-group {{ $errors->has('name_vacine') ? 'has-error' : '' }}">
                    <label class="control-label" for="name_vacine"> {{ __('Nom du vaccin') }} </label>
                    <input type="text"  class="form-control" name="name_vacine" value="{{ old('name_vacine') }}" placeholder="Nom du vaccin" id="name_vacine"/>
                    {!! $errors->first('name_vacine', '<span class="text-danger">:message</span>') !!}
                </div>

                <div class="form-group {{ $errors->has('illness') ? 'has-error' : '' }}">
                    <label class="control-label" for="illness"> {{ __('Maladie luttée') }} </label>
                    <textarea  class="form-control" name="illness" id="illness" cols="50" rows="10">{{ old('illness') }}</textarea>
                    {!! $errors->first('illness', '<span class="text-danger">:message</span>') !!}
                </div>

                <div class="mt-2 offset-md-4">
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