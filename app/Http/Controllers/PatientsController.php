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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.list_patient');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $this->validate($request, [
            'name'          => 'required|min:5',
            'birthday'      => 'required',
            'father_name'   => 'required|min:5',
            'mother_name'   => 'required|min:5',
            'mentor_name'   => 'required|min:5',
            'helper_contact'=> 'required'
        ]);

        Patients::create([
            'full_name'     => $request->name,
            'birthday'      => $request->birthday,
            'name_father'   => $request->father_name,
            'name_mother'   => $request->mother_name,
            'name_mentor'   => $request->mentor_name,
            'helper_contact'=> $request->helper_contact,
            'helper_email'  => $request->helper_email,
            'code_patient'  => Str::random(10),
            'user_id'       => Auth::user()->id
        ]);
        
        return redirect(route('list_patient'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function show($patients)
    {
        $info = Patients::findOrFail($patients);
        $vaccination = Patient_vaccinate::where('patient_id', '=', $patients)->get();
        // Code a revoir pour refactoring
        $vaccine_update = DB::select('SELECT * FROM vaccine_calendars WHERE id NOT IN (SELECT vaccine_calendar_id FROM patient_vaccinates WHERE patient_id = '.$patients.')');

        return view('patients.show_patient', ['infos' => $info, 'vaccinations' => $vaccination, 'vaccine_updates' => $vaccine_update]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function edit(Patients $patients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patients  $patients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patients $patients)
    {
        //
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
