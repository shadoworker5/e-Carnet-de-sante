<?php

namespace App\Http\Controllers;

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

// use Illuminate\Http\Request;

class PagesController extends Controller{
    public function dashboard(){
        // $patient_vacinate = Patient_vaccinate::all();
        // $query = DB::select('SELECT id FROM vaccine_calendars WHERE id NOT IN (SELECT vaccine_calendar_id FROM patient_vaccinates WHERE patient_id = 1)');
        $user_role = Auth::user()->user_role;
        $view = '';

        if(in_array($user_role, ['root', 'admin'])){
            $user = User::all();
            
            $genre = ['M', 'F'];
            $genre_count = [];
            foreach ($genre as $key => $value) {
                $genre_count[$value] = Patients::where(DB::raw("genre"), $value)->count();
            }

            $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            $vacinate_count = [];
            foreach ($months as $key => $value) {
                $vacinate_count[] = Patient_vaccinate::where(DB::raw("DATE_FORMAT(created_at, '%M')"), $value)->count();
            }

            $view = view('admin.dashboard', [
                        'user_count'    => $user,
                        'genre_count'   => $genre_count
                    ])->with('vacinate_count',json_encode($vacinate_count, JSON_NUMERIC_CHECK));
        }else if(in_array($user_role, ['supervisor', 'doctor'])){
            $view = view('pages.list_patient');
        }
        return $view;
    }

    public function listPatient(){
        return view('admin.patients');
    }
}
