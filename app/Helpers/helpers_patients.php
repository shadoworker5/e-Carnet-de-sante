<?php

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use App\Models\Provinces;
use App\Models\Regions;
use App\Models\Vaccine_calendar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if(!function_exists('get_all_patients')){
    function get_all_patients($per_page, $code_patient = null, $birthday = null, $born_location = null, $father = null, $mother = null, $helper_contact = null){
        if($code_patient !== null){
            $liste = Patients::where('full_name', 'like', '%'.$code_patient.'%')->OrWhere('code_patient', 'like', '%'.$code_patient.'%')->paginate($per_page);
        }else if($birthday !== null){
            $liste = getInfoPatient('birthday', $birthday, $per_page);
        }else if($born_location !== null){
            $liste = getInfoPatient('born_location', $born_location, $per_page);
        }else if($father !== null){
            $liste = getInfoPatient('name_father', $father, $per_page);
        }else if($mother !== null){
            $liste = getInfoPatient('name_mother', $mother, $per_page);
        }else if($helper_contact !== null){
            $liste = getInfoPatient('helper_contact', $helper_contact, $per_page);
        }else if($code_patient !== null && $helper_contact !== null){
            // $liste = getInfoPatient('')
        }else{
            $liste = DB::select("SELECT * FROM patients WHERE province_id IN (SELECT id FROM provinces WHERE region_id IN (SELECT id FROM regions WHERE contries_id = ".Auth::user()->contrie_id."))");
        }
        return $liste;
    }
}

if(!function_exists('getInfoPatient')){
    function getInfoPatient($field, $value, $count_item){
        return DB::select("SELECT * FROM patients WHERE $field, 'like', '%'.$value.'%' AND province_id IN (SELECT id FROM provinces WHERE region_id IN (SELECT id FROM regions WHERE contries_id = ".Auth::user()->contrie_id."))");
    }
}

if(!function_exists('get_all_vaccine')){
    function get_all_vaccine(){
        return Vaccine_calendar::all();
    }
}

if(!function_exists('get_patient_age')){
    function get_patient_age($date_naissance){
        $date_now = new DateTime('now');
        $date_naissance = new DateTime($date_naissance);
        $patient_age = $date_now->diff($date_naissance);
        
        return  $patient_age->y*12 + $patient_age->m;
    }
}

if(!function_exists('get_vacine_status_per_patient')){
    function get_vacine_status_per_patient($patient_id, $patient_birthday){
        $age = get_patient_age($patient_birthday);
        $result_calendar = [];
        $response = [];

        $query = Vaccine_calendar::all()->toArray();
        for($i = 0; $i < count($query); $i++){
            if(explode(' ', $query[$i]['patient_age'])[0] <= $age){
                $result_calendar[] = $query[$i]['id'];
            }
        }

        foreach($result_calendar as $key => $value){
            $response[] = (bool) Patient_vaccinate::wherePatient_idAndVaccine_calendar_id($patient_id, $value)->get()->toArray();
        }
        return in_array(false, $response);
    }
}

if(!function_exists('getPatientName')){
    function getPatientName($patient_id){
        $query = Patients::findOrFail($patient_id);
        
        return $query->code_patient;
    }
}

if(!function_exists('format_vaccinate_time')){
    function format_vaccinate_time($timing){
        $time = substr($timing, 0, 5);
        return $time;
    }
}

if(!function_exists('get_patient_update_status')){
    function get_patient_update_status($patient_id){
        $vacines =  DB::select('SELECT patient_age, name_vaccine FROM vaccine_calendars WHERE status = "0"');
        
        $vaccination = DB::select('SELECT patient_id, vaccine_calendar_id, name_vaccine, vacine_status, rappelle
                                FROM patient_vaccinate, vaccine_calendars
                                WHERE patient_id = '.$patient_id.' ');
        // return $vaccination;
    }
}

// if(!function_exists('get_status_vacinate_per_patient')){
//     function get_status_vacinate_per_patient($patient_id){
//         $vacines =  DB::select('SELECT patient_age, name_vaccine FROM vaccine_calendars WHERE status = "0"');
                
//         $vaccination = DB::select('SELECT patient_id, vaccine_calendar_id, name_vaccine, vacine_status, rappelle
//                                 FROM patient_vaccinate, vaccine_calendars
//                                 WHERE patient_id = '.$patient_id.' ');
//         // return $vaccination;
//     }
// }