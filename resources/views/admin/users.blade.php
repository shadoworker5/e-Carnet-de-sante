@extends('layouts.app_admin', ['title' => 'Liste des utilisateurs'])

@section('main_content')
    @livewire('list-users')

    <button data-bs-toggle="modal" data-bs-target="#edit_user_modal" onclick="addUser()" class="btn btn-primary">
        <i class="fa fa-user-plus"></i>
        {{ __("Ajouter un utilisateur") }}
    </button>
    {{-- <div>
    </div> --}}

    <div class="modal fade" id="edit_user_modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="example" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" method="POST" id="edit_user" novalidate>
                        @csrf
                        <div id="update_action">
                            {{ method_field('PUT') }}
                        </div>

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
                                <option value="root"> {{ __("Super utilisateur") }} </option>
                                <option value="admin"> {{ __("Administrateur") }} </option>
                                <option value="supervisor"> {{ __("Superviseur") }} </option>
                                <option value="collector"> {{ __("Agent collecteur") }} </option>
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

                        <button type="submit" id="submit" class="btn btn-primary"> </button>
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
            document.getElementById('edit_user').setAttribute('action', 'update_user/'+user_id);
            document.getElementById('name').value = name;
            document.getElementById('email').value = email;
            document.getElementById("modal_title").innerText = "Modifier l'utilisateur"
            document.getElementById("submit").innerText = "Modifier"
        }

        function addUser(){
            document.getElementById('edit_user').setAttribute('action', 'update_user');
            document.getElementById("modal_title").innerText = "Ajouter un utilisateur"
            document.getElementById("update_action").remove();
            document.getElementById("submit").innerText = "Ajouter"
        }

        function delUser(user_id){
            document.getElementById('del_user').setAttribute('action', 'update_user/'+user_id);
        }
    </script>
@endsection