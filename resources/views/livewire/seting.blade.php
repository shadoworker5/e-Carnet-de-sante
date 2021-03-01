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
                <div class="chart-area scrool">
                    {{ isset($region_name) ? $region_name->title : '' }}

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
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit_region" onclick="setRegion('{{$region['id']}}','{{$region['title']}}')">
                                                {{ __("Modifier") }}
                                            </button>
                                            
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
                <div class="chart-area scrool">
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

                                            <a href="#" class="btn btn-primary" onclick="setProvince('{{$province['id']}}','{{$province['title']}}')" data-bs-toggle="modal" data-bs-target="#edit_province">
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

    <!-- Modal de modification -->
    {{-- <div class="modal fade" id="edit_region" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Modifier la région </h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <form action="#" novalidate method="POST">
                        @csrf()
                        {{ method_field('PUT') }}
                        
                        <label for="region"> Nom de la région </label>
                        <input type="text" class="form-control mb-2" value="{{ isset($region_name) ? $region_name->title : '' }}" id="region" minlength="2" required name="region" placeholder="Nom de la région">
                        <div class="invalid-feedback">
                            Veuillez le nom de la région
                        </div>                     
                        
                        <div>
                            <button type="submit" class="btn btn-primary mt-2 pull-right"> Submit </button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div> --}}

    {{--<div class="modal fade" id="edit_province" tabindex="-1" aria-labelledby="example" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Confirmer </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('provinces.update', 1) }}" novalidate method="POST">
                        @csrf()
                        {{ method_field('PUT') }}
                        
                        <label for="province"> Nom de la province </label>
                        <input type="text" class="form-control mb-2" value="{{ isset($province_name) ? $province_name->title : '' }}" id="province" minlength="2" required name="province" placeholder="Nom de la province">
                        <div class="invalid-feedback">
                            Veuillez le nom de la région
                        </div>                     
                        
                        <div>
                            <button type="submit" class="btn btn-primary mt-2 pull-right"> Submit </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>--}}
</div>