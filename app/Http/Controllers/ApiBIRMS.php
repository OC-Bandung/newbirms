<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sirup;


class ApiBIRMS extends Controller
{
    public function sirupAll($year)
	{
		$sirup = Sirup::where("tahun", $year)->limit(5)->get(); 
    	return response()->json($sirup)->header('Access-Control-Allow-Origin', '*');
	}

}
