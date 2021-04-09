<?php

namespace App\Http\Controllers;

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use App\Models\Regions;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller{
    public function index(){
        // Recuperation des utilisateurs
        $user = User::all();

        // Recuperation des regions
        $list_region = [];
        $region = Regions::all();

        // Recuperation des patients par region
        $list_patient_per_region = get_all_patient_per_regions($region->toArray());

        for($i = 0; $i < count($region); $i++) {
            $list_region[] = $region[$i]['title'];
        }

        // Recuperation des statistiques des patients a jour
        $count_patient = get_patient_update_status(Patients::all()->toArray());

        // Recuperation du genre des patients
        $genre = ['M', 'F'];
        $genre_count = [];

        foreach($genre as $key => $value){
            $genre_count[$value] = Patients::where(DB::raw("genre"), $value)->count();
        }

        // Recuperation des vaccinations
        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $vacinate_count = [];
        foreach($months as $key => $value){
            $vacinate_count[] = Patient_vaccinate::where(DB::raw("DATE_FORMAT(created_at, '%b')"), $value)->count();
        }

        return view('admin.dashboard', [
                    'user_count'    => $user,
                    'genre_count'   => $genre_count,
                    'list_region'   => $list_region,
                    'count_patient' => $count_patient,
                    'list_patient_per_region' => $list_patient_per_region
                ])->with('vacinate_count',json_encode($vacinate_count, JSON_NUMERIC_CHECK));
    }

    public function listUser(){
        return view('admin.users');
    }

    public function setings(){
        return view('admin.setings');
    }

    public function notifyCampagne(){
        return view('admin.campagne');
    }
}
