<?php

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use App\Models\Vaccine_calendar;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

if(!function_exists('get_all_patients')){
    function get_all_patients($per_page, $code_patient = null, $birthday = null, $born_location = null, $father = null, $mother = null, $helper_contact = null){
        // else if($code_patient !== null && $birthday !== null){
        //     $liste = Patients::where('full_name', 'like', '%'.$code_patient.'%')
        //                         ->OrWhere('code_patient', 'like', '%'.$code_patient.'%')
        //                         ->AndWhere('birthday', 'like', '%'.$birthday.'%')->OrWhere('birthday', '=', 'null')
        //                         ->AndWhere('name_father', 'like', '%'.$father.'%')->OrWhere('name_father', '=', 'null')
        //                         ->AndWhere('name_mother', 'like', '%'.$mother.'%')->OrWhere('name_mother', '=', 'null')
        //                         ->AndWhere('helper_contact', 'like', '%'.$helper_contact.'%')->OrWhere('helper_contact', '=', 'null')
        //                         ->AndWhere('born_location', 'like', '%'.$born_location.'%')->OrWhere('born_location', '=', 'null')
        //                         ->paginate($per_page);
        
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
            $liste = Patients::paginate($per_page);
        }
        return $liste;
    }
}

if(!function_exists('getInfoPatient')){
    function getInfoPatient($field, $value, $count_item){
        return Patients::where($field, 'like', '%'.$value.'%')->paginate($count_item);
    }
}

if(!function_exists('get_all_vaccine')){
    function get_all_vaccine(){
        return Vaccine_calendar::all();
    }
}

if(!function_exists('get_status_vacinate_per_patient')){
    function get_status_vacinate_per_patient($patient_id){
        $vacines =  DB::select('SELECT patient_age, name_vaccine FROM vaccine_calendars WHERE status = "0"');
                
        $vaccination = DB::select('SELECT patient_id, vaccine_calendar_id, name_vaccine, vacine_status, rappelle
                                FROM patient_vaccinate, vaccine_calendars
                                WHERE patient_id = '.$patient_id.' ');
        return $vaccination;
    }
}

if(!function_exists('get_patient_age')){
    function get_patient_age($date_naissance){
        $date_now = new DateTime('now');
        $date_naissance = new DateTime($date_naissance);
        $patient_age = $date_now->diff($date_naissance);
        
        return  $patient_age->y*12 + $patient_age->m;
        // $date_now = Carbon::now()->isoFormat('Y-M-d');
        // $date_naissance = Carbon::createFromDate($date_naissance)->age;
        // // $date_naissance = Carbon::parse($date_naissance)->diff(Carbon::now())->format("y*12 years, %m ");
        // return $date_naissance;
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