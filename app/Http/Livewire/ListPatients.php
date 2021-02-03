<?php

namespace App\Http\Livewire;

use App\Models\Patients;
use Livewire\Component;
use Livewire\WithPagination;

class ListPatients extends Component
{
    use WithPagination;
    
    public $i = 0;
    public $per_page = 10;
    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.list-patients', [
            'patients' => get_all_patients($this->per_page, $this->search)
        ]);
    }
}
