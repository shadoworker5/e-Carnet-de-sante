<?php

use App\Models\Patients;
use App\Models\Vaccine_calendar;
use Illuminate\Support\Facades\DB;

if(!function_exists('get_all_patients')){
    function get_all_patients($item, $query = null){
        if($query === null){
            $liste = Patients::paginate($item);
        }else{
            $liste = Patients::where('full_name', 'like', '%'.$query.'%')->OrWhere('code_patient', 'like', '%'.$query.'%')->paginate($item); 
        }
        return $liste;
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

if(!function_exists('get_vacine_status_per_patient')){
    function get_vacine_status_per_patient($patient_id){
        $query = (bool)DB::select('SELECT id FROM vaccine_calendars WHERE id NOT IN (SELECT vaccine_calendar_id FROM patient_vaccinates WHERE patient_id = '.$patient_id.')');

        return $query === false ? 'Pas à jour' : 'A jour';
    } 
}