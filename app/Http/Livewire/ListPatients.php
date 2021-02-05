<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class ListPatients extends Component
{
    use WithPagination;
    
    public $i = 0;
    public $per_page = 10;
    public $code_patient, $birthday, $born_location, $name_father, $name_mother, $helper_contact;
    public $result = [];

    public function searchPatient(){
        # code...
    }

    public function updating(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.list-patients', [
            'patients' => get_all_patients($this->per_page, $this->code_patient, $this->birthday, $this->born_location, $this->name_father, $this->name_mother,$this->helper_contact)
        ]);
    }
}
