<?php

namespace App\Http\Controllers;

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use App\Models\Regions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller{
    public function index(){
            $user = User::all();
            
            $genre = ['M', 'F'];
            $genre_count = [];
            foreach ($genre as $key => $value) {
                $genre_count[$value] = Patients::where(DB::raw("genre"), $value)->count();
            }

            $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            $vacinate_count = [];
            foreach ($months as $key => $value) {
                $vacinate_count[] = Patient_vaccinate::where(DB::raw("DATE_FORMAT(created_at, '%b')"), $value)->count();
            }

            return view('admin.dashboard', [
                        'user_count'    => $user,
                        'genre_count'   => $genre_count
                    ])->with('vacinate_count',json_encode($vacinate_count, JSON_NUMERIC_CHECK));
    }

    public function listUser(){
        return view('admin.users');
    }

    public function setings(){
        return view('admin.setings');
    }
}