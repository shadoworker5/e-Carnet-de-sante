<?php

namespace App\Http\Controllers;

use App\Models\Provinces;
use Illuminate\Http\Request;

class BackEndController extends Controller{
    public function getProvince($region_id){
        return Provinces::where('region_id', '=', $region_id)->get();
    }
}
