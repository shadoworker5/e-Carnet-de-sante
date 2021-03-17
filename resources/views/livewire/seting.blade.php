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

    {{-- Formulaire d'ajout de region et de province --}}
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"> {{ __('Ajouter des régions de votre pays') }} </h6>
            </div>
            
            <div class="card-body">
                <div class="chart-area">
                    @php
                        $list_contries = App\Models\Contries::all()->toArray();
                    @endphp

                    <form action="{{ route('regions.store') }}" enctype="multipart/form-data" novalidate method="POST">
                        @csrf()

                        {{-- <div class="form-group">
                            <label for="contry"> {{ __("Veuillez choisir un pays") }} </label>
                            <select name="contry" required id="contry" class="form-control mb-3">
                                <option value=""> {{ __("Veuillez choisir un pays") }} </option>
                                @for($i = 0; $i < count($list_contries); $i++)
                                    <option value=""> {{ __("Veuillez choisir un pays $contry[$loop->index]") }} </option>
                                    <option value='{{ $list_contries["$i"]["id"] }}'> {{ $list_contries[$i]['nom_fr'] }}</option>
                                @endfor
                            </select>
                        </div> --}}
                        
                        <div class="form-group">
                            <label for="list_region">
                                {{ __("Veuillez choisir un fichier excel ou csv") }}
                                <a href="{{ asset('files/description.xlsx') }}" download="files/description.xlsx" class="text-primary">
                                    <i class="fa fa-question-circle" title="Télécharger un exemplaire de fichier"></i>
                                </a>
                            </label>
                            <input type="file" class="form-control" id="list_region" accept=".xlsx,.csv" required name="list_region">
                            <div class="invalid-feedback">
                                Veuillez choisir un bon fichier
                            </div>                     
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary mt-2"> Submit </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"> {{ __('Ajouter les provinces par région de votre pays') }} </h6>
            </div>
            
            <div class="card-body">
                <div class="chart-area">
                    <form action="{{ route('provinces.store') }}" novalidate method="POST">
                        @csrf()

                        <select name="region_id" required id="region_id" class="form-control mb-3">
                            <option value=""> Choisir une région </option>
                            @foreach($list_regions as $region)
                                <option value="{{ $region['id'] }}"> {{ $region['title'] }}</option>
                            @endforeach
                        </select>

                        <div id="province_list" >
                            <input type="text" class="form-control mb-2" id="province_1" minlength="2" required name="province_1" placeholder="Nom de la province">
                            <div class="invalid-feedback">
                                Veuillez le nom de la province
                            </div>                     
                        </div>

                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" id="remove_province" class="btn btn-danger mt-2"> - </button>
                            <button type="button" id="add_province" class="btn btn-primary mt-2"> + </button>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary mt-2"> Submit </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de moditification d'une province --}}
    <div class="modal fade" id="edit_province" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="example" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Modifier la province </h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_edit_province" novalidate method="POST">
                        @csrf()
                        {{ method_field('PUT') }}
                        
                        <label for="region_id"> Nom de la région </label>
                        <select name="region_id" required id="region_id_for_province" class="form-control mb-3">
                            <option value=""> Choisir une région </option>
                            @foreach($list_regions as $region)
                                <option value="{{ $region['id'] }}"> {{ $region['title'] }}</option>
                            @endforeach
                        </select>

                        <label for="province"> Nom de la province </label>
                        <input type="text" class="form-control mb-2" id="province" minlength="2" required name="province" placeholder="Nom de la province">
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
    </div>    
</div>