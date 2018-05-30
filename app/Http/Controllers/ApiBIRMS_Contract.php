<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sirup;
use Illuminate\Support\Facades\DB;

class ApiBIRMS_contract extends Controller
{
    function get_contract($ocid) {

/*------------------------------*/
/* Settings
/*------------------------------*/

        $dbplanning = env('DB_PLANNING');
        $dbcontract = env('DB_CONTRACT');
        $dbmain     = env('DB_PRIME');

/*------------------------------*/
/* General
/*------------------------------*/

        $date = '20100101';
        $tag = 'planning';
 
        $pieces = explode("-", $ocid);
 	    $sirup_id = $pieces[2];
        $pgid = '';
 
/*------------------------------*/
/* Planning Stage
/*------------------------------*/
    	   
        $sql_intro = "select * from tbl_sirup where sirupID = '". $sirup_id ."' ";

        $results = DB::select($sql_intro);
        $results = $results[0];
        
        $date = $results->tanggal_awal_pengadaan;
        $ocid = env('OCID') . $results->sirupID;
        $id = $ocid .'-01-'.$tag;
    	$contract_name = $results->nama;
        $city = $results->kldi;
        $unit = $results->satuan_kerja;

        $metode = $results->metode_pengadaan;
        switch ($metode) {
            case 1:
                $initiationType = 'Lelang Umum';
            break;
            case 2:
                $initiationType = 'Lelang Sederhana';
            break;
            case 3:
                $initiationType = 'Lelang Terbatas';
            break;
            case 4:
                $initiationType = 'Seleksi Umum';
            break;
            case 5:
                $initiationType = 'Seleksi Sederhana';
            break;
            case 6:
                $initiationType = 'Pemilihan Langsung';
            break;
            case 7:
                $initiationType = 'Penunjukan Langsung';
            break;
            case 8:
                $initiationType = 'Pengadaan Langsung';
            break;
            case 9:
                $initiationType = 'e-Purchasing';
            break;
            case 10:
                $initiationType = 'Sayembara';
            break;
            case 11:
                $initiationType = 'Kontes';
            break;
            case 12:
                $initiationType = 'Lelang Cepat';
            break;
            default:
                $initiationType = '';
        }

        $contactPoint = array('name'=>$results->satuan_kerja);

        $buyer = array( 'name' =>  $results->kldi,
                        'contactPoint' => $contactPoint );    


    	$planning_value = array('amount' =>  $results->pagu, 'currency'=> env('CURRENCY') );

        $amount = array('amount'=> $results->pagu,
                        'currency'=>'IDR');

        $budget = array('id' => $ocid,
                        'description' => $results->sumber_dana_string,
                        'amount'=>$amount);
    	
        ///compiling all stages together
    	$planning_stage = array('rationale' => null,
    							'budget' => $budget,
                                'uri'=> env('LINK_SIRUP18').$sirup_id);

/*------------------------------*/
/* Award Stage
/*------------------------------*/     
        
        $winning_bidder = "0";
        $award_amount = "0";
        $items = "0";

        if ($results->pagu <= 200000000) { //Non Lelang (Non Competitive)
            $sql_selection = "SELECT
                                $dbplanning.tbl_pekerjaan.pekerjaanID,
                                $dbplanning.tbl_pekerjaan.sirupID,
                                $dbcontract.tpekerjaan.pid,
                                $dbcontract.tpengadaan.pgid,
                                $dbcontract.tpengadaan.ta,
                                $dbplanning.tbl_pekerjaan.kodepekerjaan,
                                $dbplanning.tbl_pekerjaan.namapekerjaan,
                                $dbplanning.tbl_pekerjaan.anggaran,
                                $dbcontract.tpekerjaan.hps,
                                IF($dbcontract.tpengadaan.nilai_nego<>0,$dbcontract.tpengadaan.nilai_nego, $dbcontract.tpengadaan_pemenang.nilai) AS nilai,
                                $dbcontract.tpengadaan_pemenang.perusahaannama,
                                $dbcontract.tpengadaan_pemenang.perusahaanalamat,
                                $dbcontract.tpengadaan_pemenang.perusahaannpwp,
                                $dbcontract.tpekerjaan.lokasi,
                                $dbcontract.tpekerjaan.saltid,
                                $dbcontract.tpekerjaan.lat,
                                $dbcontract.tpekerjaan.lng,
                                $dbcontract.tpekerjaan.place_id,
                                $dbcontract.tpekerjaan.formatted_address,
                                $dbcontract.tpekerjaan.administrative_area_level_3
                                FROM
                                $dbplanning.tbl_pekerjaan
                                LEFT JOIN $dbcontract.tpekerjaan
                                ON $dbplanning.tbl_pekerjaan.pekerjaanID = $dbcontract.tpekerjaan.pekerjaanID 
                                LEFT JOIN $dbcontract.tpengadaan
                                ON $dbcontract.tpengadaan.pid = $dbcontract.tpekerjaan.pid 
                                LEFT JOIN $dbcontract.tpengadaan_pemenang
                                ON $dbcontract.tpengadaan_pemenang.pgid = $dbcontract.tpengadaan.pgid
                                WHERE
                                sirupID = ".$sirup_id." AND $dbplanning.tbl_pekerjaan.namapekerjaan = '".$contract_name."'";

            $results = DB::select($sql_selection);
            
            if (!empty($results)) { 
                $results = $results[0];    

                $winning_bidder = $results->perusahaannama;
                $award_amount = $results->nilai;
                $pgid = $results->pgid;

                $list_of_items_sql = "select * from $dbcontract.tpengadaan_rincian where pgid = '". $pgid ."' ";
                $items = DB::select($list_of_items_sql);
            }
            
        } else { //Lelang (Competitive)
            $sql_selection = "select * from $dbcontract.tlelangumum where sirupID = '". $sirup_id ."' ";
            $results = DB::select($sql_selection);

			if (!empty($results)) { 
                $results = $results[0];

                $winning_bidder = $results->pemenang;
                $award_amount = $results->nilai_nego;
				$items = "";
            } 
        }

        //build the award stage
        $award_stage = array('winning_bidder' => $winning_bidder ,
                             'award_amount' => $award_amount , 
                             'items' => $items);


/*------------------------------*/
/* Release
/*------------------------------*/    
    	$release  = array(  
                            'language'=>'id',
                            'ocid' => $ocid ,
    						'id' => $id,
    						'date' => $date,
    						'tag' => $tag,
    						'initiationType' => $initiationType,
                            'buyer'=> $buyer,
    						'planning' => $planning_stage,
                            'initiation' => '',
                            'award' => $award_stage,
                            'contract' => '',
                            'implementation' => ''
    					  );

    	return response()->json($release)->header('Access-Control-Allow-Origin', '*');

    	  // return response()->json($results)->header('Access-Control-Allow-Origin', '*');
	  
	}
}
