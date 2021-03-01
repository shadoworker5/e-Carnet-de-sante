@extends('layouts.app_admin', ['title' => 'Réglages'])

@section('main_content')
    @livewire('seting')

    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"> {{ __('Ajouter des régions de votre pays') }} </h6>
                </div>
                
                <div class="card-body">
                    <div class="chart-area">
                        <form action="{{ route('regions.store') }}" novalidate method="POST">
                            @csrf()
                            <div id="field_list" >
                                <input type="text" class="form-control mb-2" id="region_1" minlength="2" required name="region_1" placeholder="Nom de la région">
                                <div class="invalid-feedback">
                                    Veuillez le nom de la région
                                </div>                     
                            </div>

                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" id="remove_field" class="btn btn-danger mt-2"> - </button>
                                <button type="button" id="add_field" class="btn btn-primary mt-2"> + </button>
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
                        @php
                            use App\Models\Regions;
                            $list_regions = Regions::where('contries_id', '=', Auth::user()->contrie_id)->get();
                        @endphp

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
    </div>

    <!-- Modal de modification -->
    <div class="modal fade" id="edit_region" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Modifier la région </h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <form action="" id="form_edit_region" novalidate method="POST">
                        @csrf()
                        {{ method_field('PUT') }}
                        
                        <label for="region"> Nom de la région </label>
                        <input type="text" class="form-control mb-2"  id="region" minlength="2" required name="region" placeholder="Nom de la région">
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
@endsection

@section('script')
    <script src="{{ asset('js/form_validate.js') }}"></script>
    <script>
        function setRegion(region_id, region_name){
            document.getElementById('region').value = region_name;
            document.getElementById('form_edit_region').setAttribute('action', 'regions/'+region_id);
        }

        function setProvince(province_id, province_name){
            document.getElementById('province').value = province_name;
            document.getElementById('form_edit_province').setAttribute('action', 'provinces/'+province_id);
        }

        let count_child = 1
        document.getElementById('add_field').addEventListener('click', event => {
            let parent_field = document.getElementById('field_list');
            let field = document.createElement('input');
            field.type = "text";
            field.placeholder = "Nom de la région"
            field.name = "region_"+count_child;
            field.id = "region_"+count_child;
            field.required = true
            field.minLength = 2
            field.className = "form-control";
            field.style.marginBottom = "10px";

            if(count_child < 5){
                count_child += 1;
                parent_field.appendChild(field);
            }
        });

        document.getElementById('remove_field').addEventListener('click', event => {
            let parent_field = document.getElementById('field_list');
            
            if(count_child > 1){
                count_child -= 1;
                parent_field.removeChild(parent_field.lastChild)
            }
        });

        // Gestion du formulaire des provinces
        let count_field = 2
        let parent_field = document.getElementById('province_list');
        document.getElementById('add_province').addEventListener('click', event => {
            let field = document.createElement('input');
            field.type = "text";
            field.placeholder = "Nom de la province"
            field.name = "province_"+count_field;
            field.id = "province_"+count_field;
            field.required = true
            field.minLength = 2
            field.className = "form-control";
            field.style.marginBottom = "10px";

            if(count_field < 5){
                count_field += 1;
                parent_field.appendChild(field);
            }
        });

        document.getElementById('remove_province').addEventListener('click', event => {
            if(count_field > 1){
                count_field -= 1;
                parent_field.removeChild(parent_field.lastChild)
            }
        });
    </script>
@endsection