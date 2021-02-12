<?php

namespace App\Http\Controllers;

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use App\Models\Vaccine_calendar;
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
    public function index()
    {
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
            'name'          => 'required|min:5',
            'birthday'      => 'required',
            'genre'         => 'required',
            'born_location' => 'required|min:2',
            'father_name'   => 'required|min:5',
            'mother_name'   => 'required|min:5',
            'mentor_name'   => 'required|min:5',
            'helper_contact'=> 'required'
        ]);

        Patients::create([
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
        
        // Code a revoir pour refactoring
        // $vacinate_count[] = Patient_vaccinate::where(DB::raw("DATE_FORMAT(created_at, '%M')"), $value)->count();
        
        // $update = Vaccine_calendar::where(DB::raw('SELECT vaccine_calendar_id FROM patient_vaccinates WHERE WHERE patient_id = '.$patients))->get();

        // dd($update);

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
            'helper_email'  => $request->helper_email,
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
}
