<?php

namespace App\Http\Controllers;

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use App\Models\Provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackEndController extends Controller{
    public $liste;
    public $error_msg = "Les informations saisies ne nous permettent pas de vous donner les informations du carnet de vaccination !";
    public $warning = "Veuillez saisir les informations du patient avant de continuer";

    public function getProvince($region_id){
        return Provinces::where('region_id', '=', $region_id)->get();
    }

    public function showForm(){
        return view('pages.search');
    }

    public function searchQuery($field, $value){
        return Patients::where($field, '=', $value)->get()->toArray();
    }

    public function getResponse(Request $request){
        if($request->code_patient !== null && $request->full_name !== null &&
            $request->birthday !== null && $request->born_location !== null &&
            $request->father_name !== null && $request->mother_name !== null
            ){
            $this->liste = Patients::where([
                                        ['code_patient', '=', "$request->code_patient"],
                                        ['full_name', '=', "$request->full_name"],
                                        ['birthday', '=', "$request->birthday"],
                                        ['born_location', '=', "$request->born_location"],
                                        ['name_father', '=', "$request->name_father"],
                                        ['name_mother', '=', "$request->name_mother"]
                                    ])->get()->toArray();

        }else if($request->code_patient !== null){
            $this->liste = $this->searchQuery('code_patient', $request->code_patient);
        }else if($request->full_name !== null){
            $this->liste = $this->searchQuery('full_name', $request->full_name);
        }else if($request->birthday !== null){
            $this->liste = $this->searchQuery('birthday', $request->birthday);
        }else if($request->born_location !== null){
            $this->liste = $this->searchQuery('born_location', $request->born_location);
        }else if($request->father_name !== null){
            $this->liste = $this->searchQuery('name_father', $request->father_name);
        }else if($request->mother_name !== null){
            $this->liste = $this->searchQuery('name_mother', $request->mother_name);
        }

        if($this->liste === null){
            return redirect()->route('search')->with('warning', $this->warning);
        }else if(count($this->liste) === 1){
            $info = Patients::findOrFail($this->liste[0]['id']);
            $vaccination = Patient_vaccinate::where('patient_id', '=', $this->liste[0]['id'])->get();

            $vaccine_update = DB::select('SELECT * FROM vaccine_calendars WHERE id NOT IN (SELECT vaccine_calendar_id FROM patient_vaccinates WHERE patient_id = '.$this->liste[0]['id'].')');

            return view('pages.response', ['infos' => $info, 'vaccinations' => $vaccination, 'vaccine_updates' => $vaccine_update]);
        }else{
            return redirect()->route('search')->with('error', $this->error_msg);
        }
    }
}
