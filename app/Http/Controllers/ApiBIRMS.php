<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sirup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ApiBIRMS extends Controller
{
    public function contractsPerYear($year)
	{
		$results = Sirup::where("tahun", $year)->limit(5)->get(); 
    	return response()->json($results)->header('Access-Control-Allow-Origin', '*');
	}

	public function contractsAll()
	{
    	$results = Sirup::paginate(15);

		// return response()->json($results['data']['sirupID']);
		// array('ocid' => $results->sirupID, 'nama' => $results->nama)


    	return response()->json($results)->header('Access-Control-Allow-Origin', '*');
	}

	/* get_pns function
	pns/{kewenangan}:{year}
		kewenangan attribut
		pa => 'Pengguna Anggaran'
		ppk => 'Pejabat Pembuat Komitmen'
		ppbj => 'Pejabat Pengadaan Barang Jasa'
		pphp => 'Pejabat Penerima Hasil Pekerjaan'
		pptk => 'Pejabat Pelaksana Teknis Pekerjaan'
		bpwal => 'Bendahara Pengeluaran SK Walikota'
		bppakpa => 'Bendahara Pengeluaran SK Pengguna Anggaran/Kuasa'
		kelkerja => 'Anggota Kelompok Kerja ULP'

		example : https:/birms.bandung.go.id/api/pns/pa:2017
	*/

	function get_pns($kewenangan,$year) {
	    $dbplanning = '2016_birms_eproject_planning';
	    $dbcontract = '2016_birms_econtract';
	    $dbmain 	= '2016_birms_prime';
	    switch ($kewenangan) {
	      case "pa" :
	        $sktipeID = 1;
	      break;
	      case "ppk" :
	        $sktipeID = 2;
	      break;
	      case "ppbj" :
	        $sktipeID = 3;
	      break;
	      case "pphp" :
	        $sktipeID = 4;
	      break;
	      case "pptk" :
	        $sktipeID = 5;
	      break;
	      case "bpwal" :
	        $sktipeID = 6;
	      break;
	      case "bppakpa" :
	        $sktipeID = 7;
	      break;
	      case "kelkerja" :
	        $sktipeID = 8;
	      break;
	      default:
	        $sktipeID = 1;
	    }

	    /*$sql = 'SELECT
					TRIM(identity_no) AS nip ,
					fullname AS nama ,
					ringkasan AS kewenangan ,
					tglsk ,
					nosk ,
					tbl_skpd.unitID ,
					tbl_skpd.nama AS skpdnama
				FROM
					2016_birms_eproject_planning.tr_sk_user
				LEFT OUTER JOIN tbl_sk ON tr_sk_user.skID = tbl_sk.skID
				LEFT OUTER JOIN tbl_sk_tipe ON tbl_sk.sktipeID = tbl_sk_tipe.sktipeID
				LEFT OUTER JOIN :dbmain.tbl_user ON tr_sk_user.usrID = :dbmain.tbl_user.usrID
				LEFT OUTER JOIN :dbmain.tbl_skpd ON tbl_sk.skpdID = :dbmain.tbl_skpd.skpdID
				WHERE
					YEAR(tglsk) = :year
				AND tbl_sk.sktipeID = :sktipeID
				AND identity_no <> \'\'
				GROUP BY nip, nama, kewenangan, tglsk, nosk, unitID, skpdnama
				ORDER BY
					unitID ,
					TRIM(nip)';

		$results = DB::select($sql, ['dbplanning'=> $dbplanning, 'dbcontract' => $dbcontract, 'dbmain' => $dbmain, 'year' => $year,'sktipeID' => $sktipeID]);*/

		$sql = 'SELECT
					*
				FROM
					2016_birms_eproject_planning.tr_sk_user
				LEFT OUTER JOIN tbl_sk ON tr_sk_user.skID = tbl_sk.skID 
				LEFT OUTER JOIN tbl_sk_tipe ON tbl_sk.sktipeID = tbl_sk_tipe.sktipeID			
				LEFT OUTER JOIN 2016_birms_prime.tbl_user ON tr_sk_user.usrID = 2016_birms_prime.tbl_user.usrID
				LEFT OUTER JOIN 2016_birms_prime.tbl_skpd ON tbl_sk.skpdID = 2016_birms_prime.tbl_skpd.skpdID
				LIMIT 10';

		$results = DB::select($sql);
    	return response()->json($results)->header('Access-Control-Allow-Origin', '*');
	  
	}
}
