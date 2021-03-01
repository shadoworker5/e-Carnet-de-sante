<?php

namespace App\Http\Livewire;

use App\Models\Provinces;
use App\Models\Regions;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChooseRegion extends Component
{
    public $region_id;

    public function updating(){
        $this->region_id = $this->region_id;
    }

    public function render(){
        $list_regions = Regions::where('contries_id', '=', Auth::user()->contrie_id)->get();
        return view('livewire.choose-region', ['list_regions' => $list_regions, 'list_provinces' => Provinces::where('region_id', '=', $this->region_id)->get()]);
    }
}
