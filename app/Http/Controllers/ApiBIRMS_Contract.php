<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sirup;
use Illuminate\Support\Facades\DB;

class ApiBIRMS_contract extends Controller
{
     

	function get_contract($ocid) {
	    $dbplanning = '2016_birms_eproject_planning';
	    $dbcontract = '2016_birms_econtract';
	    $dbmain 	= '2016_birms_prime';
	   
 		
		$sql = 'SELECT * 
FROM
	2016_birms_econtract.tpengadaan
LEFT JOIN 2016_birms_prime.tbl_skpd ON 2016_birms_econtract.tpengadaan.skpdid = tbl_skpd.skpdid
LEFT JOIN 2016_birms_prime.tbl_instansi ON 2016_birms_prime.tbl_skpd.instansiid = tbl_instansi.instansiid
LEFT JOIN 2016_birms_econtract.tsumberdana ON 2016_birms_econtract.tpengadaan.sumberdanaid = tsumberdana.sumberdanaid
LEFT JOIN 2016_birms_econtract.tklasifikasi ON tpengadaan.klasifikasiID = tklasifikasi.klasifikasiID
LEFT JOIN 2016_birms_econtract.tpengadaan_pemenang ON tpengadaan.pgid = tpengadaan_pemenang.pgid       
LEFT JOIN 2016_birms_econtract.tpekerjaan ON tpengadaan.pid = tpekerjaan.pid
LEFT JOIN 2016_birms_econtract.tkontrak_penunjukan ON tpengadaan.pgid = tkontrak_penunjukan.pgid
LEFT JOIN 2016_birms_eproject_planning.tbl_pekerjaan ON tpekerjaan.pekerjaanID = 2016_birms_eproject_planning.tbl_pekerjaan.pekerjaanID
LEFT JOIN 2016_birms_eproject_planning.tbl_sirup ON 2016_birms_eproject_planning.tbl_pekerjaan.sirupID = 2016_birms_eproject_planning.tbl_sirup.sirupID
-- WHERE tpengadaan.ta = 2016 AND tbl_pekerjaan.sirupID <> 0 AND NOT ISNULL(tbl_pekerjaan.sirupID) 
LIMIT 1';

		
		
		$results = DB::select($sql);
		$results = $results[0];
    	

    	$ocid = env('OCID') . $results->sirupID ;

		$id = '1';
		$date = '20100101';
		$tag = 'planning';

		$initiationType = 'tender';
 
    	
 
 		//////////////////////	
 		// planning stage 	//
 		//////////////////////

    	

    	$rationale = $results->nama;

    	$project = array('project' =>   $results->namapekerjaan);
 
    	$planning_value = array('amount' =>  $results->anggaran, 'currency'=> env('CURRENCY') );

    	$budget = array(
    					'id' => $results->kode ,
    					 'description' => $results->sumberdana,
    					 'value' => $planning_value
    					);

    	///compiling all stages together
    	$planning_stage = array('rationale' =>  $rationale,
    							'budget' => $budget );

    	//////////////////////
    	//////////////////////

    	$tender_stage = array ("status" => "active");


    	//return $results;

    	$release  = array( 'ocid' => $ocid ,
    						'id' => $id,
    						'date' => $date,
    						'tag' => $tag,
    						'initiationType' => 'tender',
    						'planning' => $planning_stage,
    						'tender' => $tender_stage
    						
    					  );
    	return response()->json($release)->header('Access-Control-Allow-Origin', '*');

    	  // return response()->json($results)->header('Access-Control-Allow-Origin', '*');
	  
	}
}
