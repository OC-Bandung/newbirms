<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sirup;
use App\Paketlng;
use App\Paketpl;
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
		$results = Sirup::selectRaw('sirupID, CONCAT(\'ocds-afzrfb-\',sirupID) AS ocid, tahun, nama, pagu')
    						->orderBy('sirupID')
    						->paginate(15);

// <<<<<<< master
// =======
// 		// return response()->json($results['data']['sirupID']);
// 		// array('ocid' => $results->sirupID, 'nama' => $results->nama)


// >>>>>>> master
//     	return response()->json($results)->header('Access-Control-Allow-Origin', '*');
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
	    $dbplanning = env('DB_PLANNING');
	    $dbcontract = env('DB_CONTRACT');
	    $dbmain 	= env('DB_PRIME');

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
					$dbplanning.tr_sk_user
				LEFT OUTER JOIN tbl_sk ON tr_sk_user.skID = tbl_sk.skID 
				LEFT OUTER JOIN tbl_sk_tipe ON tbl_sk.sktipeID = tbl_sk_tipe.sktipeID			
				LEFT OUTER JOIN $dbmain.tbl_user ON tr_sk_user.usrID = $dbmain.tbl_user.usrID
				LEFT OUTER JOIN $dbmain.tbl_skpd ON tbl_sk.skpdID = $dbmain.tbl_skpd.skpdID
				LIMIT 10';
		$results = DB::select($sql);
    	return response()->json($results)->header('Access-Control-Allow-Origin', '*');
	  
	}

	public function graph1()
	{
		$sql = 'SELECT tahun, (nilaikontrak/1000000000) AS nilaikontrak FROM '.env('DB_CONTRACT').'.vlelang_bypaket ORDER BY tahun ASC';
		$rs1 = DB::select($sql);

		$rowdata = array();
		$data = array();
		foreach($rs1 as $row) {
			array_push($data, array($row->tahun, (float)$row->nilaikontrak));
		}
		array_push($rowdata, array("name"=>"Lelang", "data"=> $data));

		$sql = 'SELECT tahun, (nilaikontrak/1000000000) AS nilaikontrak FROM '.env('DB_CONTRACT').'.vpl_bypaket ORDER BY tahun ASC';
		$rs1 = DB::select($sql);

		$data = array();
		foreach($rs1 as $row) {
			array_push($data, array($row->tahun, (float)$row->nilaikontrak));
		}
		array_push($rowdata, array("name"=>"Pengadaan Langsung", "data"=> $data));
		$results = $rowdata;

    	return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
	}

	public function graph2($year)
	{
		$sql = 'SELECT
					`tlelangumum`.`skpdID` AS `skpdID` ,
					`tbl_skpd`.`nama` AS `nama` ,
					`tlelangumum`.`ta` AS `ta` ,
					SUM(`tlelangumum`.`anggaran`)/1000000000 AS `anggaran`,
					SUM(`tlelangumum`.`nilai_nego`)/1000000000 AS `nilai_kontrak`
				FROM
					(
						'.env('DB_CONTRACT').'.`tlelangumum`
						LEFT JOIN '.env('DB_PRIME').'.`tbl_skpd` ON(
							(
								`tlelangumum`.`skpdID` = '.env('DB_PRIME').'.`tbl_skpd`.`skpdID`
							)
						)
					)
				WHERE
					(
						(`tlelangumum`.`nilai_nego` <> 0)
						AND(`tlelangumum`.`ta` = '.$year.')
					)
					GROUP BY
						`tlelangumum`.`skpdID` ,
						'.env('DB_PRIME').'.`tbl_skpd`.`nama`,
						`ta`
				UNION
					SELECT
						`tpengadaan`.`skpdID` AS `skpdID` ,
						`tbl_skpd`.`nama` AS `nama` ,
						`tpengadaan`.`ta` AS `ta` ,
						SUM(`tpengadaan`.`anggaran`)/1000000000 AS `anggaran`,
						SUM(`tpengadaan`.`nilai_nego`)/1000000000 AS `nilai_kontrak`
					FROM
						(
							'.env('DB_CONTRACT').'.`tpengadaan`
							LEFT JOIN '.env('DB_PRIME').'.`tbl_skpd` ON(
								(
									`tpengadaan`.`skpdID` = '.env('DB_PRIME').'.`tbl_skpd`.`skpdID`
								)
							)
						)
					WHERE
						(
							(
								`tpengadaan`.`pekerjaanstatus` = 7
							)
							AND(`tpengadaan`.`ta` = '.$year.')
						)
					GROUP BY
						`tpengadaan`.`skpdID` ,
						'.env('DB_PRIME').'.`tbl_skpd`.`nama`,
						`ta`
					ORDER BY
						`nilai_kontrak` DESC
					LIMIT 10';
		$rs1 = DB::select($sql);

		$rowdata = array();
		$data1 = array(); //pagu anggaran
		$data2 = array(); //nilai kontrak
		foreach($rs1 as $row) {
			array_push($data1, array($row->nama, (float)$row->anggaran));
			array_push($data2, array($row->nama, (float)$row->nilai_kontrak));
		}
		array_push($rowdata, array("name"=>"Pagu Anggaran", "data"=> $data1));
		array_push($rowdata, array("name"=>"Nilai Kontrak", "data"=> $data2));

		$results = $rowdata;
		return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
	}

	public function graph3($year) 
	{
		$sql = 'SELECT
					ta ,
					LEFT(tklasifikasi.kode,2) AS kodepengadaan,
					(
						CASE LEFT(tklasifikasi.kode , 2)
						WHEN "01" THEN
							"Konstruksi"
						WHEN "02" THEN
							"Pengadaan Barang"
						WHEN "03" THEN
							"Jasa Konsultansi"
						WHEN "04" THEN
							"Jasa Lainnya"
						ELSE
							"N/A"
						END
					) AS jenispengadaan ,

					COUNT(0) AS paket,	
					SUM(anggaran) AS anggaran ,
					SUM(hps) AS hps ,
					SUM(nilai_nego) AS nilaikontrak
				FROM
					'.env('DB_CONTRACT').'.tpengadaan
				LEFT JOIN '.env('DB_CONTRACT').'.tklasifikasi ON tpengadaan.klasifikasiID = tklasifikasi.klasifikasiID
				WHERE
					pekerjaanstatus = 7 AND ta = '.$year.'
				GROUP BY ta, kodepengadaan, jenispengadaan';
		$rs2 = DB::select($sql);

		$data = array();

		foreach($rs2 as $row) {
			array_push($data, array("name"=>$row->jenispengadaan, "y"=>(float)$row->nilaikontrak));
		}
		$results = $data;

		return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
	}

	public function graph4()
	{
		$sql = 'SELECT tahun, paket FROM '.env('DB_CONTRACT').'.vlelang_bypaket ORDER BY tahun ASC';
		$rs1 = DB::select($sql);

		$rowdata = array();
		$data = array();
		foreach($rs1 as $row) {
			array_push($data, array($row->tahun, (int)$row->paket));
		}
		array_push($rowdata, array("name"=>"Lelang", "data"=> $data));

		$sql = 'SELECT tahun, paket FROM '.env('DB_CONTRACT').'.vpl_bypaket ORDER BY tahun ASC';
		$rs2 = DB::select($sql);

		$data = array();
		foreach($rs2 as $row) {
			array_push($data, array($row->tahun, (int)$row->paket));
		}
		array_push($rowdata, array("name"=>"Pengadaan Langsung", "data"=> $data));
		$results = $rowdata;

    	return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
	}
}
