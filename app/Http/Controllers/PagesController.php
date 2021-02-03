<?php

namespace App\Http\Controllers;

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

// use Illuminate\Http\Request;

class PagesController extends Controller{
    public function dashboard(){
        // $patient_vacinate = Patient_vaccinate::all();
        // $query = DB::select('SELECT id FROM vaccine_calendars WHERE id NOT IN (SELECT vaccine_calendar_id FROM patient_vaccinates WHERE patient_id = 1)');
        $user = User::all();
        $patient = Patients::all();
        $patient_count = [];
        $male = Patients::where('genre', '=', 'M')->count();
        $female = Patients::where('genre', '=', 'F')->count();

        // dd($patient);
        
        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $vacinate_count = [];
        foreach ($months as $key => $value) {
            $vacinate_count[] = Patient_vaccinate::where(DB::raw("DATE_FORMAT(created_at, '%M')"), $value)->count();
        }

        return view('pages.dashboard', [
                    'patient'       => $patient, 
                    'user_count'    => $user,
                    'male_count'    => $male,
                    'female_count'  => $female
                ])->with('vacinate_count',json_encode($vacinate_count, JSON_NUMERIC_CHECK));
    }
}
