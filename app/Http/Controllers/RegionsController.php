<?php

namespace App\Http\Controllers;

use App\Imports\RegionImport;
use App\Models\Regions;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Auth;

class RegionsController extends Controller
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
    public function store(Request $request){
        if($request->contries_id !== null){
            session(['contry_id' => "$request->contries_id"]);
            Excel::import(new RegionImport, $request->list_region);
        }
        session()->forget('contry_id');

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
        $this->validate($request, [
            'region' => 'required|min:2'
        ]);

        $region = Regions::findOrFail($id);
        $region->update([
            'title' => $request->region
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
        //
    }

    public function importForm(){
        # code...
    }
}
