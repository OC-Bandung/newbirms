<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sirup;
use Illuminate\Support\Facades\DB;

class ApiBIRMS_contract extends Controller
{
     

	function get_contract($ocid) {
	     //////////////////////  
        // settings    //
        //////////////////////

        $dbplanning = '2016_birms_eproject_planning';
	    $dbcontract = '2016_birms_econtract';
	    $dbmain 	= '2016_birms_prime';

        //////////////////////  
        // general //
        //////////////////////

        $id = '1';
        $date = '20100101';
        $tag = 'planning';
        $initiationType = 'tender';
 
      

	    $sirup_id = '3662192';
        $pgid = '14252';

	
 
 		//////////////////////	
 		// planning stage 	//
 		//////////////////////

    	   
        $sql_intro = "select * from tbl_sirup where sirupID = '". $sirup_id ."' ";

        $results = DB::select($sql_intro);
        $results = $results[0];
         
        $ocid = env('OCID') . $results->sirupID ;
    	$contract_name =  $results->nama;
        $city = $results->kldi ;
        $unit = $results->satuan_kerja;

    	$planning_value = array('amount' =>  $results->pagu, 'currency'=> env('CURRENCY') );


    	///compiling all stages together
    	$planning_stage = array('contract_name' =>  $contract_name,
    							'city' => $city,
                                'unit' => $unit,
                                'planning_value' => $planning_value );

    	////////////////////// 
        //   selection stage  //
        //////////////////////
        $sql_selection = "select * from 2016_birms_econtract.tpengadaan_pemenang where pgid = '". $pgid ."' ";

        $results = DB::select($sql_selection);
        $results = $results[0];

        $winning_bidder = $results->perusahaannama;
        $award_amount = $results->nilai;


        $list_of_items_sql = "select * from  2016_birms_econtract.tpengadaan_rincian where pgid = '". $pgid ."' ";
        $items = DB::select($list_of_items_sql);


        //build the award stage
        $award_stage = array('winning_bidder' => $winning_bidder ,
                             'award_amount' => $award_amount , 
                             'items' => $items);


      

    	$release  = array(  'ocid' => $ocid ,
    						'id' => $id,
    						'date' => $date,
    						'tag' => $tag,
    						'initiationType' => 'tender',
    						'planning' => $planning_stage ,
                            'award' => $award_stage
    						
    					  );
    	return response()->json($release)->header('Access-Control-Allow-Origin', '*');

    	  // return response()->json($results)->header('Access-Control-Allow-Origin', '*');
	  
	}
}
