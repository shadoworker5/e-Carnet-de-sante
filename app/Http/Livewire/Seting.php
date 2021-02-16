<?php

namespace App\Http\Livewire;

use App\Models\Contries;
use App\Models\Provinces;
use App\Models\Regions;
use Livewire\Component;

class Seting extends Component
{
    public $contry_id, $region_id;


    public function showRegion($id){
        $this->region_id = $id;
    }

    public function updatingContry_id(){
        $this->contry_id = $this->contry_id;
    }

    public function render()
    {
        return view('livewire.seting', ['list_regions' => Regions::where('contries_id', '=', $this->contry_id)->get()->toArray(), 'list_provinces' => Provinces::where('region_id', '=', $this->region_id)->get()->toArray(), 'contries' => Contries::all()]);
    }
}