<?php

namespace App\Http\Livewire;

use App\Models\Patients;
use Livewire\Component;

class FindPatients extends Component
{
    public $code_patient;
    public $error;
    public $result;

    public function getPatient($value){
        if($value !== null){
            $this->result = Patients::where('code_patient', '=', $value)->get();
            if(count($this->result) !== 0)
                return redirect()->route('patient.show', $this->result[0]['id']);
            else{
                return $this->error = 'error';
            }
        }else{
            return; // $this->error = '';
        }
    }
    public function searchPatient(){
        return $this->getPatient($this->code_patient);
    }
    public function render(){
        return view('livewire.find-patients', ['patient' => $this->searchPatient()]);
    }
}
