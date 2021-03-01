<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return Patients::orderBy('id')->get();
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
            'success' => "Données sauvegarder avec succès"
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

    public function getPatientList($province_id){
        return  Patients::where('province_id', '=', $province_id)->get();        //view('vaccines.vacinate_patient');
    }
}
