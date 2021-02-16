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
                        <form>
                            <div id="field_list" >
                                <input type="text" class="form-control mb-2" id="region_1" name="region_1" placeholder="Nom de la région">                                    
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
                    <h6 class="m-0 font-weight-bold text-primary"> {{ __('Liste des régions de votre pays') }} </h6>
                </div>
                
                <div class="card-body">
                    <div class="chart-area">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let count_child = 0
        let add_field = document.getElementById('add_field');
        add_field.addEventListener('click', event => {
            count_child += 1;
            let parent_field = document.getElementById('field_list');
            let field = document.createElement('input');
            field.type = "text";
            field.placeholder = "Nom de la région"
            field.name = "region_"+count_child;
            field.id = "region_"+count_child;
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
            
            if(count_child > 0){
                count_child -= 1;
                parent_field.removeChild(parent_field.lastChild)
            }
        });

        // if(count_child == 0){
        //     remove_field.remove()
        // }else{
        //     // remove_field.show
        // }

    </script>
@endsection