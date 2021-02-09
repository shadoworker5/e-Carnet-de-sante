<?php

namespace App\Http\Controllers;

use App\Models\Vaccine_calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacineCalendarController extends Controller
{
    public function __construct(){
        // $this->middleware(['authadmin', 'authsupervisor']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if(in_array(Auth::user()->user_role, ['collector', 'guest'])){
            return redirect()->route('home');
        }

        return view('pages.calendar', ['vacines' => Vaccine_calendar::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(in_array(Auth::user()->user_role, ['collector', 'guest'])){
            return redirect()->route('home');
        }

        return view('vaccines.vacine_calendar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(in_array(Auth::user()->user_role, ['collector', 'guest'])){
            return redirect()->route('home');
        }

        $this->validate($request, [
            'age'               => 'required|min:5',
            'name_vacine'       => 'required',
            'illness'           => 'required|min:5'
        ]);

        Vaccine_calendar::create([
                'patient_age'       => $request->age,
                'name_vaccine'      => $request->name_vacine,
                'illness_against'   => $request->illness,
                'user_id'           => Auth::user()->id
        ]);
        
        return redirect(route('add_calendar.create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vaccine_calendar  $vaccine_calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Vaccine_calendar $vaccine_calendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vaccine_calendar  $vaccine_calendar
     * @return \Illuminate\Http\Response
     */
    public function edit($vaccine_calendar)
    {
        if(in_array(Auth::user()->user_role, ['collector', 'guest'])){
            return redirect()->route('home');
        }

        $vacine = Vaccine_calendar::findOrFail($vaccine_calendar);
        return view('vaccines.edit_calendar', ['vacine' => $vacine]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vaccine_calendar  $vaccine_calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vaccine_calendar)
    {
        if(in_array(Auth::user()->user_role, ['collector', 'guest'])){
            return redirect()->route('home');
        }
        
        $this->validate($request, [
            'age'               => 'required|min:5',
            'name_vacine'       => 'required',
            'vacine_status'     => 'required',
            'illness'           => 'required|min:5'
        ]);
        
        $vacine = Vaccine_calendar::findOrFail($vaccine_calendar);
        $vacine->update([
            'patient_age'       => $request->age,
            'name_vaccine'      => $request->name_vacine,
            'illness_against'   => $request->illness,
            'status'            => $request->vacine_status,
            'user_id'           => Auth::user()->id
        ]);

        return redirect()->route('calendar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vaccine_calendar  $vaccine_calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vaccine_calendar $vaccine_calendar)
    {
        //
    }
}
