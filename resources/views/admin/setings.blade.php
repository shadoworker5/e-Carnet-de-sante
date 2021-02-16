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
@endsection

@section('script')
    <script src="{{ asset('js/form_validate.js') }}"></script>
    <script>
        let count_child = 1
        let add_field = document.getElementById('add_field');
        add_field.addEventListener('click', event => {
            let parent_field = document.getElementById('field_list');
            count_child += 1;
            let field = document.createElement('input');
            field.type = "text";
            field.placeholder = "Nom de la région"
            field.name = "region_"+count_child;
            field.id = "region_"+count_child;
            field.required = true
            field.minLength = 2
            field.className = "form-control";
            field.style.marginBottom = "10px";

            if(count_child <= 5){
                parent_field.appendChild(field);
            }
            console.log("Child: "+count_child);
        });

        let remove_field = document.getElementById('remove_field');
        remove_field.addEventListener('click', event => {
            let parent_field = document.getElementById('field_list');
            
            if(count_child > 1){
                count_child -= 1;
                parent_field.removeChild(parent_field.lastChild)
            }
        });

        // Gestion du formulaire des provinces
        let count_field = 1
        let add_province = document.getElementById('add_province');
        let parent_field = document.getElementById('province_list');
        add_province.addEventListener('click', event => {
            count_field += 1;
            let field = document.createElement('input');
            field.type = "text";
            field.placeholder = "Nom de la province"
            field.name = "region_"+count_field;
            field.id = "region_"+count_field;
            field.required = true
            field.minLength = 2
            field.className = "form-control";
            field.style.marginBottom = "10px";

            if(count_field <= 5){
                parent_field.appendChild(field);
            }
        });

        let remove_province = document.getElementById('remove_province');
        remove_province.addEventListener('click', event => {
            if(count_field > 1){
                count_field -= 1;
                parent_field.removeChild(parent_field.lastChild)
            }
        });
    </script>
@endsection