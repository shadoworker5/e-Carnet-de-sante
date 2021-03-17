@extends('layouts.app_admin', ['title' => 'Réglages'])

@section('main_content')
    @livewire('seting')

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