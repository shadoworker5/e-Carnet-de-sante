<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use App\Models\Provinces;
use App\Models\Regions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class APIPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Patients::orderBy('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'province_id'   => 'required',
            'user_id'       => 'required',
            'name_patient'  => 'required|min:5',
            'birthday'      => 'required',
            'genre'         => 'required',
            'born_location' => 'required|min:2',
            'father_name'   => 'required|min:5',
            'mother_name'   => 'required|min:5',
            'mentor_name'   => 'required|min:5',
            'helper_contact'=> 'required'
        ]);

        Patients::create([
            'province_id'   => $request->province_id,
            'full_name'     => $request->name_patient,
            'birthday'      => $request->birthday,
            'genre'         => $request->genre,
            'born_location' => $request->born_location,
            'name_father'   => $request->father_name,
            'name_mother'   => $request->mother_name,
            'name_mentor'   => $request->mentor_name,
            'helper_contact'=> $request->helper_contact,
            'helper_email'  => $request->helper_email !== null ? $request->helper_email : 'NP',
            'code_patient'  => Str::random(10),
            'user_id'       => $request->user_id
        ]);
        return response()->json([
            'response' => "Données sauvegarder avec succès"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPatientList($region_id, $province_id = null){
        $list_patient = [];
        $list_province = [];
        $patients_tmp = "code_patient, full_name, birthday, born_location, name_father, name_mother, genre, name_mentor, helper_contact";

        if($province_id === null){
            $province = Provinces::where('region_id', '=', $region_id)->get()->toArray();
            for($i = 0; $i < count($province); $i++){
                $list_province [] = $province[$i]['id'];
            }
            $patients_tmp = DB::select("SELECT $patients_tmp FROM patients WHERE province_id IN (SELECT id FROM provinces WHERE region_id = $region_id)");

            return $patients_tmp;
        }

        if($province_id !== null){
            $patient = Patients::where('province_id', '=', $province_id)->get();
            for($i = 0; $i < count($patient); $i++){
                $list_patient[] = [
                    "code_patient"      => $patient[$i]['code_patient'],
                    "full_name"         => $patient[$i]['full_name'],
                    "birthday"          => $patient[$i]['birthday'],
                    "born_location"     => $patient[$i]['born_location'],
                    "name_father"       => $patient[$i]['name_father'],
                    "name_mother"       => $patient[$i]['name_mother'],
                    "genre"             => $patient[$i]['genre'],
                    "name_mentor"       => $patient[$i]['name_mentor'],
                    "helper_contact"    => $patient[$i]['helper_contact'],
                    "helper_email"      => $patient[$i]['helper_email'],
                ];
            }
        }

        return $list_patient;
    }
}
