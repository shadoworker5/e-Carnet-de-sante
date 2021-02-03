<?php

use App\Models\Vaccine_calendar;

if(!function_exists('get_vaccine_name')){
    function get_vaccine_name($id){
        $query = Vaccine_calendar::findOrFail($id);
        
        return $query->name_vaccine;
    }
}

if(!function_exists('get_vaccine_validity')){
    function get_vaccine_validity($id, $vaccine_date = null){
        $query = Vaccine_calendar::findOrFail($id)->validity_vaccine;
        $test = date('Y-m-d') > $query;

        return '$test ? 1 : 0';
    }
}