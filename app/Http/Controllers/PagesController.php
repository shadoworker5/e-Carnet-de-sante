<?php

namespace App\Http\Controllers;

// use App\Http\Traits\VerifyStatus;
use App\Models\Patient_vaccinate;
use App\Models\Patients;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// use Illuminate\Http\Request;

class PagesController extends Controller{
    public function index(){
        $user = User::all();
        $patients = Patients::orderBy('id')->get();
        
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

        return view('pages.home', [
                    'user_count'    => $user,
                    'genre_count'   => $genre_count,
                    'patients'      => $patients
                ])->with('vacinate_count', json_encode($vacinate_count, JSON_NUMERIC_CHECK));
    }
    
    public function profile(){
        return view('profile.show');
    }

    public function offlineForm(){
        return view('offlines.offline_vacinate');
    }

    public function offlineSubmission(){
        $submission = Patient_vaccinate::where('user_id', '=', Auth::id())->get();
        
        return view('offlines.list_vacinate', ['submissions' => $submission]);
    }

    public function offlineShow(){
        return view('offlines.offline_show');
    }
}