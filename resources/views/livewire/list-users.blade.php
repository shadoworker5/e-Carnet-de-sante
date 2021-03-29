<div>
    <h1 class="text-center"> {{ __("Liste des utilisateurs") }} </h1>
    
    <div class="row mt-4">
        <div class="row">
            <div class="col-md-3">
                <select class="form-control" wire:model.lazy="per_page" name="choose" id="choose">
                    @for($i = 5; $i <= 100; $i += 5)
                        <option value="{{ $i }}"> {{ $i }} <option>
                    @endfor
                </select>
            </div>

            <div class="form-floating col-md-3">
                <input type="text" class="form-control" wire:model.defer="user_name" placeholder="Nom de l'utilisateur" id="user_name" name="user_name">
            </div>
            
            <div class="form-floating col-md-3">
                <input type="text" class="form-control" wire:model.defer="user_mail" placeholder="Address e-mail" id="floatingFather" name="user_mail">
            </div>

            <button class="btn btn-primary col-md-3" wire:click="searchUser">
                <i class="fa fa-search"></i>
                {{ __("Rechercher") }}
            </button>
        </div>

    </div>

    <div class="table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> {{ __('#indice') }} </th>

                    <th> {{ __('Nom') }} </th>

                    <th> {{ __('E-mail') }} </th>
                    
                    <th> {{ __('Type d\'utilisateur') }} </th>

                    <th> {{ __('Status du compte') }} </th>
                    
                    <th> {{ __('Action') }} </th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td> {{ ++$loop->index }} </td>

                        <td> {{ $user->name }} </td>

                        <td> {{ $user->email }} </td>
                        
                        <td> {{ $user->user_role }} </td>
                        
                        <td class="text-center">
                            {!! $user->account_status === '1' ? '<i class="fa fa-check fa-2x text-success"></i>' : '<i class="fa fa-times fa-2x text-danger"></i>' !!}
                        </td>
                        
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#" href="#" data-bs-toggle="modal" data-bs-target="#edit_user_modal" class="btn text-white" style="background-color: #00ade9" onclick="setUser('{{$user->id}}', '{{$user->name}}', '{{$user->email}}', '{{$user->user_role}}')">
                                    <i class="fa fa-edit"></i>
                                </a>
                                
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_user" onclick="delUser('{{ $user->id }}')">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <p class="text-danger text-center"> Aucune ligne trouvée</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
            
        <form id="del_user" action="" method="POST" style="display: none;">
            @csrf
            {{ method_field('DELETE') }}
        </form>
    </div>
    
    <div class="offset-md-5">
        {{ $users->links() }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="delete_user" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __("Confirmer la suppression") }} </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body text-center">
                    {{ __("Etes-vous sûr de vouloir supprimer cet utilisateur?") }}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> {{ __("Fermer") }} </button>
                    <a href="#" class="btn btn-danger" onclick="document.getElementById('del_user').submit();">
                        <i class="fa fa-trash-alt"></i>
                        {{ __("Supprimer") }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>