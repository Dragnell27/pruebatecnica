<?php

namespace App\Http\Controllers;

use App\Models\Param;
use Illuminate\Http\Request;

class ParamController extends Controller
{
    public function countries(){
        $countries = Param::where('param_type_id', 1)->get();

        return response()->json([
            'success' => true,
            'message' => 'Params retrieved successfully',
            'data'    => $countries
        ], 200);
    }

    public function cities($country){
        $cities = Param::where('param_type_id', 2)->where('param_id',$country)->get();

        return response()->json([
            'success' => true,
            'message' => 'Params retrieved successfully',
            'data'    => $cities
        ], 200);
    }

    public function coin($country){
        $coin = Param::where('param_type_id', 3)->where('param_id',$country)->get();

        return response()->json([
            'success' => true,
            'message' => 'Params retrieved successfully',
            'data'    => $coin
        ], 200);
    }
}
