<?php

namespace App\Http\Controllers;

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use Illuminate\Http\Request;

class APIVacinatePatient extends Controller
{
    protected $image_path;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code_patient'          => 'required|min:8',
            'vaccine_id'            => 'required',
            'date_vacination'       => 'required|date',
            'heure_vaicnation'      => 'required',
            'doctor_name'           => 'required|min:5',
            'doctor_phone'          => 'required|min:10',
            'lot_number_vaccine'    => 'required|min:5',
        ]);

        if ($request->file('image_path') !== null && $request->file('image_path')->isValid()){
            $this->image_path = $request->file('image_path')->getClientOriginalName();

            $request->image_path->move(public_path('flacon_images'), $this->image_path);
        }

        $patient_info = Patients::where('code_patient', '=', $request->code_patient)->get()->toArray()[0];

        Patient_vaccinate::create([
            'user_id'                => $request->user_id,
            'patient_id'             => $patient_info['id'],
            'vaccine_calendar_id'    => $request->vaccine_id,
            'date_vacination'        => $request->date_vacination,
            'time_vacination'        => $request->heure_vaicnation,
            'name_doctor'            => $request->doctor_name,
            'doctor_contact'         => $request->doctor_phone,
            'lot_number_vacine'      => $request->lot_number_vaccine,
            'vacine_status'          => '1',
            'rappelle'               => $request->rappelle !== "" ? $request->rappelle : null,
            'path_capture'           => $request->image_path !== "" ? $this->image_path : null
        ]);
        return response()->json([
            'response' => "Données de vaccination sauvegarder avec succès"
        ]);

        // if(get_vacine_status_per_patient($patient_info['id'], $patient_info['birthday'])){
        // }else{
        //     return response()->json([
        //         'response' => "Le patient $request->code_patient est à jours des vaccination"
        //     ]);
        // }
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
}
