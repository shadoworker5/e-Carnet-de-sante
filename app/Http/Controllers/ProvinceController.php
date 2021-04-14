<?php

namespace App\Http\Controllers;

use App\Imports\ProvinceImport;
use App\Models\Provinces;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Auth;

class ProvinceController extends Controller
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
        return Provinces::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $this->userGuard();

        if($request->region_id !== null){
            session(['region_id' => "$request->region_id"]);
            Excel::import(new ProvinceImport, $request->list_province);
        }
        session()->forget('region_id');

        return redirect()->route('setings');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $this->userGuard();

        $this->validate($request, [
            'province'  => 'required|min:2',
            'region_id' => 'required'
        ]);

        $province = Provinces::findOrFail($id);
        $province->update([
            'title' => $request->province,
            'region_id' => $request->region_id
        ]);

        return redirect()->route('setings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userGuard();
        Provinces::destroy($id);
        return redirect()->route('setings');
    }
}
