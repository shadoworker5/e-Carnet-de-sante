<?php

namespace App\Http\Controllers;

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use App\Models\Vaccine_calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientVacinateController extends Controller
{
    public function __construct(){
        // $this->middleware(['authadmin', 'authsupervisor']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vaccines = Vaccine_calendar::all();
        return view('vaccines.vacinate_patient', ['vaccines' => $vaccines]);
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
            'patient_code'          => 'required|min:8',
            'vaccine_name'          => 'required',
            'date_vaccinate'        => 'required|date',
            'time_vaccinate'        => 'required',
            'doctor_name'           => 'required|min:5',
            'doctor_phone'          => 'required|min:10',
            'lot_number_vaccine'    => 'required|min:5',
        ]);
        
        $patient_id = Patients::where('code_patient', '=', $request->patient_code)->get()->toArray()[0]['id'];

        // if(get_vacine_status_per_patient($patient_id) === "Pas à jour"){
            Patient_vaccinate::create([
                'user_id'               => Auth::id(),
                'patient_id'            => $patient_id,
                'vaccine_calendar_id'   => $request->vaccine_name,
                'date_vacination'       => $request->date_vaccinate,
                'time_vacination'       => $request->time_vaccinate,
                'name_doctor'           => $request->doctor_name,
                'doctor_contact'        => $request->doctor_phone,
                'lot_number_vacine'     => $request->lot_number_vaccine,
                'vacine_status'         => '1',
                'rappelle'              => $request->rappelle !== "" ? $request->rappelle : null,
                'path_capture'          => $request->image_path !== "" ? $request->image_path : null    
            ]);
        // }
        return redirect(route('patient.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient_vaccinate  $patient_vaccinates
     * @return \Illuminate\Http\Response
     */
    public function show($patient_vaccinates)
    {
        $vaccine_info = Patient_vaccinate::findOrFail($patient_vaccinates);
        $code_patient = Patients::findOrFail($vaccine_info->patient_id);

        return view('vaccines.detail', ['vaccine_info' => $vaccine_info, 'patient_code' => $code_patient->code_patient]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\patient_vaccinates  $patient_vaccinates
     * @return \Illuminate\Http\Response
     */
    public function edit($patient_vaccinates)
    {
        $vaccines = Vaccine_calendar::all();
        $vaccine_info = Patient_vaccinate::findOrFail($patient_vaccinates);
        $patient_code = Patients::findOrFail($vaccine_info->patient_id);
        
        return view('vaccines.edit', ['vaccine_info' => $vaccine_info, 'vaccines' => $vaccines, 'patient_code' => $patient_code->code_patient]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\patient_vaccinates  $patient_vaccinates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'patient_code'          => 'required|min:8',
            'vaccine_name'          => 'required',
            'date_vaccinate'        => 'required|date',
            'time_vaccinate'        => 'required',
            'doctor_name'           => 'required|min:5',
            'doctor_phone'          => 'required|min:10',
            'lot_number_vaccine'    => 'required|min:5',
        ]);

        $patient_id = Patients::where('code_patient', '=', $request->patient_code)->get()->toArray()[0]['id'];
        
        $vaccines = Patient_vaccinate::findOrFail($id);
        $vaccines->update([
            'user_id'               => Auth::id(),
            'patient_id'            => $patient_id,
            'vaccine_calendar_id'   => $request->vaccine_name,
            'date_vacination'       => $request->date_vaccinate,
            'time_vacination'       => $request->time_vaccinate,
            'name_doctor'           => $request->doctor_name,
            'doctor_contact'        => $request->doctor_phone,
            'lot_number_vacine'     => $request->lot_number_vaccine,
            'vacine_status'         => '1',
            'rappelle'              => $request->rappelle !== "" ? $request->rappelle : null,
            'path_capture'          => $request->image_path !== "" ? $request->image_path : null    
        ]);
        return redirect('patient');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\patient_vaccinates  $patient_vaccinates
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient_vaccinate $patient_vaccinates)
    {
        //
    }
}
