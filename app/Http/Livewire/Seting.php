<?php

namespace App\Http\Livewire;

use App\Models\Contries;
use App\Models\Provinces;
use App\Models\Regions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Seting extends Component
{
    public $contry_id, $region_id, $region_name, $province_name;


    public function showRegion($id){
        $this->region_id = $id;
        // $this->render();
    }

    // public function editRegion($id){
    //     $this->region_name = Regions::findOrFail($id);
    // }

    public function editProvince($id){
        $this->province_name = Provinces::findOrFail($id);
    }

    public function updatingContry_id(){
        $this->contry_id = $this->contry_id;
        $this->render();
    }

    public function render()
    {
        return view('livewire.seting', ['list_regions' => Regions::where('contries_id', '=', $this->contry_id)->get()->toArray(), 'list_provinces' => Provinces::where('region_id', '=', $this->region_id)->get()->toArray(), 'contries' => Contries::all()]);
    }
}
