<?php

namespace App\Http\Controllers;

use App\Models\Patient_vaccinate;
use App\Models\Patients;
use Illuminate\Http\Request;

class APIVacinatePatient extends Controller
{
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
        $patient_id = Patients::where('code_patient', '=', $request->code_patient)->get()->toArray()[0]['id'];

        if(get_vacine_status_per_patient($patient_id) === "Pas à jour"){
            Patient_vaccinate::create([
                'user_id'           => base64_decode(request()->user_id),
                'patient_id'        => $patient_id,
                'vaccine_id'        => $request->vaccine_id,
                'date_vacination'   => $request->date_vacination,
                'time_vacination'   => $request->heure_vaicnation,
                'name_doctor'       => $request->doctor_name,
                'doctor_contact'    => $request->doctor_phone,
                'lot_number_vacine' => $request->lot_number_vaccine,
                'vacine_status'     => '1',
                'rappelle'          => $request->rappelle !== ""?: null,
                'path_capture'      => $request->image_path !== ""?: null
            ]);
            return response()->json([
                'success' => 'Données sauvegarder avec succès'
            ]);
        }else{
            // code
        }
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
