<?php

namespace App\Http\Controllers;

use App\Models\Param;
use Illuminate\Http\Request;

class ParamController extends Controller
{

    //Trae todas los países
    public function countries(){
        $countries = Param::where('param_type_id', 1)->get();

        return response()->json([
            'success' => true,
            'message' => 'Params retrieved successfully',
            'data'    => $countries
        ], 200);
    }

    //Trae las ciudades de un país
    public function cities($country){
        $cities = Param::where('param_type_id', 2)->where('param_id',$country)->get();

        return response()->json([
            'success' => true,
            'message' => 'Params retrieved successfully',
            'data'    => $cities
        ], 200);
    }
}
