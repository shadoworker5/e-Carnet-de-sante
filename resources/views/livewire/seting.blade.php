<div class="row">
    @if(in_array(Auth::user()->user_role, ['root', 'admin']))
        <select name="contry_id" id="contry_id" wire:model.lazy="contry_id" class="form-control mb-3">
            <option value=""> Choisir un pays </option>
            @foreach($contries as $contry)
                <option value="{{ $contry->id }}"> {{ $contry->nom_fr }}</option>
            @endforeach
        </select>
    @endif
    
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"> {{ __('Liste des régions de votre pays') }} </h6>
                
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header"> {{ __("Options") }} </div>
                        <a class="dropdown-item" href="#" onclick="window.location.reload();"> {{ __("Actualiser") }} </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="chart-area">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> {{ __("#Indice") }} </th>
                                <th> {{ __("Designation") }} </th>
                                <th> {{ __("Action") }} </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($list_regions as $region)
                                <tr>
                                    <td> {{ ++$loop->index }} </td>
                                    <td> {{ __( $region['title'] ) }} </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="#" class="btn btn-warning">
                                                {{ __("Modifier") }}
                                            </a>

                                            <button wire:click="showRegion({{ $region['id'] }})" class="btn btn-success">
                                                {{ __("Afficher") }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <p class="text-danger text-center"> Aucune ligne trouvée</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"> {{ __("Liste des provinces de votre pays") }} </h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header"> {{ __("Options") }} </div>
                        <a class="dropdown-item" href="#" onclick="window.location.reload();"> {{ __("Actualiser") }} </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                <div class="chart-area">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> {{ __("#Indice") }} </th>
                                <th> {{ __("Designation") }} </th>
                                <th> {{ __("Action") }} </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($list_provinces as $province)
                                <tr>
                                    <td> {{ ++$loop->index }} </td>
                                    <td> {{ __($province['title']) }} </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="#" class="btn btn-danger">
                                                {{ __("Supprimer") }}
                                            </a>

                                            <a href="#" class="btn btn-primary">
                                                {{ __("Modifier") }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <p class="text-danger text-center"> Aucune ligne trouvée</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>