<?php

namespace App\Http\Controllers;

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientsController extends Controller
{
    protected function userGuard(){
        if(in_array(Auth::user()->user_role, ['guest'])){
            return redirect()->route('home');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $this->userGuard();
        if(Auth::user()->user_role === 'collector'){
            return redirect(route('home'));
        }
        return view('pages.list_patient');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->userGuard();
        return view('patients.add_patient');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->userGuard();

        $this->validate($request, [
            'province_id'   => 'required',
            'name'          => 'required|min:5',
            'birthday'      => 'required',
            'genre'         => 'required',
            'born_location' => 'required|min:2',
            'father_name'   => 'required|min:5',
            'mother_name'   => 'required|min:5',
            'mentor_name'   => 'required|min:5',
            'helper_contact'=> 'required|regex:/^\+/'
        ]);

        Patients::create([
            'province_id'   => $request->province_id,
            'full_name'     => $request->name,
            'birthday'      => $request->birthday,
            'genre'         => $request->genre,
            'born_location' => $request->born_location,
            'name_father'   => $request->father_name,
            'name_mother'   => $request->mother_name,
            'name_mentor'   => $request->mentor_name,
            'helper_contact'=> $request->helper_contact,
            'helper_email'  => $request->helper_email !== null ? $request->helper_email : 'NP',
            'code_patient'  => Str::random(10),
            'user_id'       => Auth::user()->id
        ]);

        if(Auth::user()->user_role === 'collector'){
            return redirect(route('home'));
        }
        return redirect(route('patient.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function show($patients)
    {
        $this->userGuard();

        $info = Patients::findOrFail($patients);
        $vaccination = Patient_vaccinate::where('patient_id', '=', $patients)->get();

        $vaccine_update = DB::select('SELECT * FROM vaccine_calendars WHERE id NOT IN (SELECT vaccine_calendar_id FROM patient_vaccinates WHERE patient_id = '.$patients.')');

        return view('patients.show_patient', ['infos' => $info, 'vaccinations' => $vaccination, 'vaccine_updates' => $vaccine_update]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function edit($patients)
    {
        $this->userGuard();

        $patient = Patients::findOrFail($patients);
        return view('patients.edit_patient', ['patient' => $patient]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $patients)
    {
        $this->userGuard();

        $this->validate($request, [
            'name'          => 'required|min:5',
            'birthday'      => 'required',
            'born_location' => 'required|min:2',
            'father_name'   => 'required|min:5',
            'mother_name'   => 'required|min:5',
            'mentor_name'   => 'required|min:5',
            'helper_contact'=> 'required'
        ]);

        $patient = Patients::findOrFail($patients);
        $patient->update([
            'full_name'     => $request->name,
            'birthday'      => $request->birthday,
            'genre'         => $request->genre,
            'born_location' => $request->born_location,
            'name_father'   => $request->father_name,
            'name_mother'   => $request->mother_name,
            'name_mentor'   => $request->mentor_name,
            'helper_contact'=> $request->helper_contact,
            'helper_email'  => $request->helper_email !== null ? $request->helper_email : 'NP',
            'user_id'       => Auth::user()->id
        ]);

        if(Auth::user()->user_role === 'collector'){
            return redirect(route('home'));
        }
        return redirect()->route('patient.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patients $patients)
    {
        //
    }

    function getUserByinfo($per_page = 15, $code_patient = null, $birthday = null, $born_location = null, $father = null, $mother = null, $helper_contact = null){
        // if($code_patient !== null){
        //     $liste = Patients::where('full_name', 'like', '%'.$code_patient.'%')->OrWhere('code_patient', 'like', '%'.$code_patient.'%')->paginate($per_page);
        // }else if($birthday !== null){
        //     $liste = $this->getInfoPatient('birthday', $birthday, $per_page);
        // }else if($born_location !== null){
        //     $liste = $this->getInfoPatient('born_location', $born_location, $per_page);
        // }else if($father !== null){
        //     $liste = $this->getInfoPatient('name_father', $father, $per_page);
        // }else if($mother !== null){
        //     $liste = $this->getInfoPatient('name_mother', $mother, $per_page);
        // }else if($helper_contact !== null){
        //     $liste = $this->getInfoPatient('helper_contact', $helper_contact, $per_page);
        // }else if($code_patient !== null && $helper_contact !== null){
        //     // $liste = getInfoPatient('')
        // }else{
        //     $liste = Patients::paginate($per_page);
        // }

        // return view('pages.list_patient', ['patients' => $liste]);
    }

    function getInfoPatient($field, $value, $count_item){
        // return Patients::where($field, 'like', '%'.$value.'%')->paginate($count_item);
    }
}
