@extends('layouts.app_admin', ['title' => 'Liste des utilisateurs'])

@section('main_content')
    @livewire('list-users')

    <div class="modal fade" id="edit_user_modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="example" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __("Modifier l'utilisateur") }} </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" method="POST" id="edit_user" novalidate>
                        @csrf
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label class="control-label" for="name"> {{ __('Nom et prénom(s)') }} </label>
                            <input type="text" class="form-control" required name="name" id="name" value="{{ old('name') }}" placeholder="Nom et prénom(s)">
                            {!! $errors->first('name', '<span class="text-danger">:message</span>') !!}
                            <div class="invalid-feedback">
                                {{ __("Veuillez saisir l'utilisateur") }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="email"> {{ __('E-mail') }} </label>
                            <input type="email" class="form-control" required name="email" id="email" value="{{ old('email') }}" placeholder="E-mail">
                            {!! $errors->first('email', '<span class="text-danger">:message</span>') !!}
                            <div class="invalid-feedback">
                                {{ __("Veuillez renseigner l'e-mail l'utilisateur") }}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="user_right"> {{ __('Type d\'utilisateur') }} </label>
                            <select class="form-control custom-select" required name="user_right" id="user_right">
                                <option value=""> {{ __("Veuilez choisir un rôle") }} </option>
                                <option value="admin"> {{ __("Administrateur") }} </option>
                                <option value="supervisor"> {{ __("Superviseur") }} </option>
                                <option value="guest"> {{ __("Invité") }} </option>
                            </select>

                            {!! $errors->first('user_right', '<span class="text-danger">:message</span>') !!}
                            <div class="invalid-feedback">
                                {{ __("Veuillez saisir un rôle") }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="statu"> {{ __('Etat du compte') }} </label>
                            <select class="form-control custom-select" required name="statu" id="statu">
                                <option value=""> {{ __("Veuilez choisir un état") }} </option>
                                <option value="1"> {{ __("Active") }} </option>
                                <option value="0"> {{ __("Inactive") }} </option>
                            </select>

                            {!! $errors->first('statu', '<span class="text-danger">:message</span>') !!}
                            <div class="invalid-feedback">
                                {{ __("Veuillez saisir un rôle") }}
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Modifier') }}
                        </button>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal"> {{ __("Fermer") }} </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/form_validate.js') }}"></script>
    <script>
        function setUser(user_id, name, email, user_right){
            // document.getElementById('region').value = region_name;
            // document.getElementById('edit_user').setAttribute('action', 'regions/'+region_id);
            document.getElementById('name').value = name;
            document.getElementById('email').value = email;
            let select_right = document.getElementById('user_right')
            // .value = user_right;
            select_right.option
        }
    </script>
@endsection