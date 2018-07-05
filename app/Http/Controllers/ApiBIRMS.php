<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sirup;
use App\Paketlng;
use App\Paketpl;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ApiBIRMS extends Controller
{
    public function contractsAll()
    {
        $ocid = env('OCID');
        $results = Sirup::selectRaw('sirupID, CONCAT(\'$ocid\',sirupID) AS ocid, tahun, nama, pagu')
                            ->orderBy('sirupID')
                            ->paginate(env('JSON_RESULTS_PER_PAGE', 40));
    }

    /**
     * Creates paginator from a simple array coming from DB::select
     * https://stackoverflow.com/a/44090541
     * Use url parameter per_page to increase page number
     *
     * @param $array
     * @param $request
     * @return LengthAwarePaginator
     */
    public function arrayPaginator($array, $request)
    {
        $page = Input::get('page', 1);
        $perPage = Input::get('per_page', env('JSON_RESULTS_PER_PAGE', 40));
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true),
            count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
    }

    public function contractsPerYear($year)
    {
		//$results = Sirup::where("tahun", $year)->paginate(100);
		$ocid = env('OCID');

		$dbplanning = env('DB_PLANNING');
		
		$sql = 'SELECT
		CONCAT("'.env('OCID').'","s-",tahun,"-",sirupID) AS ocid,
		tahun AS year,
		nama AS title,
		CONCAT("'.env('API_ENDPOINT').'", "/newcontract/", "'.env('OCID').'","s-",tahun,"-",sirupID) AS uri,
		pagu AS value
	FROM
	'.$dbplanning.'.tbl_sirup WHERE tahun = '.$year.' 
	UNION 
	SELECT
		CONCAT("'.env('OCID').'","b-",'.$year.',"-",tbl_pekerjaan.pekerjaanID) AS ocid,
		'.$year.' AS year,
		namapekerjaan AS title,
		CONCAT("'.env('API_ENDPOINT').'", "/newcontract/", "'.env('OCID').'","b-",'.$year.',"-",tbl_pekerjaan.pekerjaanID) AS uri,
		anggaran AS value
	FROM
	'.$dbplanning.'.tbl_pekerjaan 
	WHERE YEAR(tbl_pekerjaan.created) = '.$year.' AND sirupID = 0 AND iswork = 1';

        $results = $this->arrayPaginator(DB::select($sql), request());
    	return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
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
		$results = DB::select($sql)->paginate(env('JSON_RESULTS_PER_PAGE', 40));
    	return response()->json($results)->header('Access-Control-Allow-Origin', '*');
	  
	}

	/*--- Start Data Map Packet By Kecamatan  ---*/
	public function get_kecamatan_count($year) 
	{
	    $dbplanning = env('DB_PLANNING');
	    $dbcontract = env('DB_CONTRACT');
	    $dbmain 	= env('DB_PRIME');

		$sql = "SELECT
					unitID, 
					UPPER(TRIM(SUBSTRING(nama, POSITION(' ' IN nama), LENGTH(nama)))) AS kecamatan,
					CONVERT(IFNULL(
					(SELECT COUNT(*) FROM ".env('DB_CONTRACT').".tpekerjaan WHERE administrative_area_level_3 = kecamatan AND ta = ".$year." GROUP BY administrative_area_level_3)
					,0), CHAR(50)) AS summary
				FROM
					".env('DB_PRIME').".tbl_skpd
				WHERE
					nama LIKE 'Kecamatan%'";
		$results = DB::select($sql);
    	return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');	
	}

	public function get_kecamatan_value($year)
	{
		$dbplanning = env('DB_PLANNING');
	    $dbcontract = env('DB_CONTRACT');
	    $dbmain 	= env('DB_PRIME');

		$sql = "SELECT
					unitID,
					UPPER(TRIM(SUBSTRING(nama, POSITION(' ' IN nama), LENGTH(nama)))) AS kecamatan,
					CONVERT(IFNULL(
					(SELECT SUM(anggaran) FROM ".env('DB_CONTRACT').".tpekerjaan WHERE administrative_area_level_3 = kecamatan AND ta = ".$year." GROUP BY administrative_area_level_3)
					,0), CHAR(50)) AS summary
				FROM
					".env('DB_PRIME').".tbl_skpd
				WHERE
					nama LIKE 'Kecamatan%'";
		$results = DB::select($sql);
    	return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
	}

	/*--- End Data Map Packet By Kecamatan  ---*/

	/*--- Start Data Statistic ---*/
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
		$sql = 'SELECT ta, COUNT(*) AS paket FROM '.env('DB_CONTRACT').'.`tlelangumum` GROUP BY ta ORDER BY ta DESC LIMIT 1';
		$rscheck1 = DB::select($sql);

		$sql = 'SELECT ta, COUNT(*) AS paket FROM '.env('DB_CONTRACT').'.`tpengadaan` WHERE pekerjaanstatus = 7 GROUP BY ta ORDER BY ta DESC LIMIT 1';
		$rscheck2 = DB::select($sql);

		if (($rscheck1[0]->ta < $year) || ($rscheck2[0]->ta < $year)) {
			$year = $rscheck2[0]->ta;
		}

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
		$sql = 'SELECT ta, COUNT(*) AS paket FROM '.env('DB_CONTRACT').'.`tlelangumum` GROUP BY ta ORDER BY ta DESC LIMIT 1';
		$rscheck1 = DB::select($sql);

		$sql = 'SELECT ta, COUNT(*) AS paket FROM '.env('DB_CONTRACT').'.`tpengadaan` WHERE pekerjaanstatus = 7 GROUP BY ta ORDER BY ta DESC LIMIT 1';
		$rscheck2 = DB::select($sql);

		if (($rscheck1[0]->ta < $year) || ($rscheck2[0]->ta < $year)) {
			$year = $rscheck2[0]->ta;
		}

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

	/*--- End Data Statistic ---*/

	public function search(Request $request) {
		$dbplanning 	= env("DB_PLANNING");
    	$dbecontract 	= env("DB_CONTRACT");
    	$dbprime 		= env("DB_PRIME");

		$sql = "SELECT skpdID, unitID, satker, nama, singkatan FROM $dbprime.tbl_skpd WHERE isactive = 1 AND isparent = 1 ORDER BY unitID";
		$rsskpd = DB::select($sql);

		$rowdata = array();
		$data = array();
		foreach($rsskpd as $row) {
			array_push($data, array((INT)$row->skpdID, $row->unitID, $row->satker, $row->nama, $row->singkatan));
		}
		array_push($rowdata, array("name"=>"ref_skpd", "data"=> $data));

		if (!empty($request)) {
	    	$q 		= $request->input('q');
	    	$tahun 	= $request->input('tahun');
	    	$skpdID = $request->input('skpdID');
	    	$klasifikasi = $request->input('klasifikasi');
	    	$tahap 	= $request->input('tahap');
	    	
	    	$min 	= $request->input('min');
	    	$max 	= $request->input('max');
	    	$startdate = $request->input('startdate');
	    	$enddate = $request->input('enddate');

		
	    	switch ($tahap) {
			    case 1: //Perencanaan
			        $sql = "";
			        break;
			    case 2: //Pengadaan
			        /*$rspengadaan = DB::table($dbecontract.'.tpengadaan')
			    						->select('tpengadaan.kode', 'tpengadaan.namakegiatan', 'tpengadaan.namapekerjaan', 'tpengadaan.nilai_nego','sirupID')
			    						->leftJoin($dbecontract.'.tpekerjaan', 'tpengadaan.pid', '=', 'tpekerjaan.pid')
										->leftJoin('tbl_pekerjaan', 'tpekerjaan.pekerjaanID', '=', 'tbl_pekerjaan.pekerjaanID')
			    						->where([
												    ['tpengadaan.namapekerjaan', 'LIKE', '%makanan%'],
												    ['nilai_nego', '>=', 100],
												    ['nilai_nego', '<=', 200],
												]
			    							)	
			    						->get();*/
			        break;
			    case 3: //Pemenang
			        $sql = "";
			        break;
			    case 4: //Kontrak
			        $sql = "";
			        break;
			    case 5: //Implementasi
			        $sql = "";
			        break;        
			    default:
			    	$sql = "SELECT
								`tbl_pekerjaan`.`kodepekerjaan` ,
								`tbl_pekerjaan`.`sirupID`,
								`tbl_metode`.`nama` AS metodepengadaan,
								`tpengadaan`.`namakegiatan` ,
								`tpengadaan`.`namapekerjaan` ,
								`tpengadaan`.`nilai_nego` ,
								`tpengadaan`.skpdID,
								`tbl_skpd`.unitID,
								`tbl_skpd`.nama AS namaskpd,
								`tpengadaan`.ta,
								`tpengadaan`.anggaran,
								`tsumberdana`.sumberdana,
								`tpengadaan`.klasifikasiID,
								LEFT(`tklasifikasi`.kode,2) AS kodeklasifikasi,
								  CASE 
								     WHEN LEFT(`tklasifikasi`.kode,2) = 1 THEN 'Konstruksi'
								     WHEN LEFT(`tklasifikasi`.kode,2) = 2 THEN 'Pengadaan Barang'
								     WHEN LEFT(`tklasifikasi`.kode,2) = 3 THEN 'Jasa Konsultansi'
								     WHEN LEFT(`tklasifikasi`.kode,2) = 4 THEN 'Jasa Lainnya'
								     ELSE 'N/A'
								  END AS klasifikasi,
								`tbl_pekerjaan`.pilih_start,
								`tbl_pekerjaan`.pilih_end,
								`tbl_pekerjaan`.laksana_start,
								`tbl_pekerjaan`.laksana_end
							FROM
								`$dbecontract`.`tpengadaan`
							LEFT JOIN `$dbecontract`.`tpekerjaan` ON `tpengadaan`.`pid` = `tpekerjaan`.`pid`
							LEFT JOIN `tbl_pekerjaan` ON `tpekerjaan`.`pekerjaanID` = `tbl_pekerjaan`.`pekerjaanID`
							LEFT JOIN `tbl_metode` ON `tpekerjaan`.`metodeID` = `tbl_metode`.`metodeID`
							LEFT JOIN `$dbprime`.`tbl_skpd` ON `tpengadaan`.`skpdID` = `tbl_skpd`.`skpdID`
							LEFT JOIN `$dbecontract`.`tsumberdana` ON `tpengadaan`.sumberdanaid = `tsumberdana`.sumberdanaid
							LEFT JOIN `$dbecontract`.`tklasifikasi` ON `tpengadaan`.klasifikasiID = `tklasifikasi`.klasifikasiID
							WHERE true ";

							if (!empty($q)) {
								$sql .= " AND `tpengadaan`.`namapekerjaan` LIKE '%$q%' "; 
							}

							if (!empty($tahun)) {
								$sql .= " AND `tpengadaan`.ta = $tahun "; 
							}

							if (!empty($skpdID)) {
								$sql .= " AND `tpengadaan`.skpdID = $skpdID"; 
							}

							if (!empty($klasifikasi)) {
								$sql .= " AND LEFT(`tklasifikasi`.kode,2) = $klasifikasi"; 
							}

							if (!empty($min)) {
								$sql .= " AND (`tpengadaan`.anggaran >= $min OR `tpengadaan`.nilai_nego >= $min) "; 
							}

							if (!empty($max)) {
								$sql .= " AND (`tpengadaan`.anggaran <= $max OR `tpengadaan`.nilai_nego <= $max) "; 
							}
			    	$rspengadaan = DB::select($sql);
			}
    	} else {
    		$data['message'] = 'Silahkan isi kata yang ingin dicari terlebih dahulu';
    	}

    	$data = array();
		foreach($rspengadaan as $row) {
			array_push($data, array($row->kodepekerjaan, 
								(int)$row->sirupID, 
								$row->metodepengadaan,
								$row->namakegiatan,
								$row->namapekerjaan,
								$row->nilai_nego,
								$row->skpdID,
								$row->unitID,
								$row->namaskpd,
								$row->ta,
								$row->anggaran,
								$row->sumberdana,
								$row->klasifikasi,
								$row->pilih_start,
								$row->pilih_end,
								$row->laksana_start,
								$row->laksana_end));
		}
		array_push($rowdata, array("name"=>"pengadaan", "data"=> $data));

		//total kontrak
		array_push($rowdata, array("name"=>"totalsearch", "data"=> count($rspengadaan)));
		$results = $rowdata;
		return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
			
	}
	/*--- Recent Data ---*/
	public function planning($year) {
		$sql = 'SELECT * FROM '.env('DB_PLANNING').'.tbl_sirup ORDER BY sirupID DESC LIMIT 10';
		$rsdummy = DB::select($sql);

		$rowdata = array();
		$data = array();

		$jenis_belanja[1] = 'Barang/Jasa'; 
		$jenis_belanja[2] = 'Modal';
		
		$jenis_pengadaan[1] = 'Barang'; 
		$jenis_pengadaan[2] = 'Pekerjaan Konstruksi';
		$jenis_pengadaan[3] = 'Jasa Konsultansi';
		$jenis_pengadaan[4] = 'Jasa Lainnya';
		
		$metode_pengadaan[1] = 'Lelang Umum'; 
		$metode_pengadaan[2] = 'Lelang Sederhana'; 
		$metode_pengadaan[3] = 'Lelang Terbatas';  
		$metode_pengadaan[4] = 'Seleksi Umum';  
		$metode_pengadaan[5] = 'Seleksi Sederhana'; 
		$metode_pengadaan[6] = 'Pemilihan Langsung'; 
		$metode_pengadaan[7] = 'Penunjukan Langsung';  
		$metode_pengadaan[8] = 'Pengadaan Langsung';  
		$metode_pengadaan[9] = 'e-Purchasing'; 

		foreach($rsdummy as $row) {
			$sirupID = $row->sirupID;
			$ocid = env('OCID') . $sirupID ;

			$data['ocid'] 		= $ocid;
			$data['uri'] 		= env('LINK_SIRUP').$year."/".$sirupID;
			$data['title'] 		= $row->nama; 
			$data['project'] 	= "";
			$data['sirupID'] 	= "".$sirupID."";
			$data['SKPD']		= $row->satuan_kerja;
			$data['budget']		= array(
					'description' =>$row->sumber_dana_string,
					'amount' => array(
						'amount' => $row->pagu,
						'currency' => env('CURRENCY')
					),
					'uri' => env('LINK_SIRUP').$year."/".$sirupID
				);
			$data['mainProcurementCategory']		= $jenis_pengadaan[$row->jenis_pengadaan];
			$data['procurementMethod']				= $metode_pengadaan[$row->metode_pengadaan];
			$data['procurementMethodDetails']		= "";
			$data['awardCriteria']					= "";
			$data['tender']		= array(
					'startDate' => $row->tanggal_awal_pengadaan,
					'endDate' => $row->tanggal_akhir_pengadaan
			);
			$data['contract']	= array(
					'startDate' => $row->tanggal_awal_pekerjaan,
					'endDate' => $row->tanggal_akhir_pekerjaan
			);
			$data['created_at']		= "";
			$data['updated_at']		= "";
			array_push($rowdata, $data);
        }

		$results = $rowdata;

		return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
	}

	public function contract($year) {
		$sql =  'SELECT sirupID, tpengadaan.kode, tpengadaan.namakegiatan, tpengadaan.namapekerjaan, tpengadaan.anggaran, tpengadaan.hps, tpengadaan.nilai_nego FROM '.env('DB_CONTRACT').'.tpengadaan
				LEFT JOIN '.env('DB_CONTRACT').'.tpekerjaan ON tpengadaan.pid = tpekerjaan.pid
				LEFT JOIN '.env('DB_PLANNING').'.tbl_pekerjaan ON tpekerjaan.pekerjaanID = tbl_pekerjaan.pekerjaanID
				WHERE
				tpengadaan.pekerjaanstatus = 7 AND tpengadaan.ta = '.$year;
		$rsdummy = DB::select($sql);

		$rowdata = array();
		$data = array();

		$jenis_belanja[1] = 'Barang/Jasa'; 
		$jenis_belanja[2] = 'Modal';
		
		$jenis_pengadaan[1] = 'Barang'; 
		$jenis_pengadaan[2] = 'Pekerjaan Konstruksi';
		$jenis_pengadaan[3] = 'Jasa Konsultansi';
		$jenis_pengadaan[4] = 'Jasa Lainnya';
		
		$metode_pengadaan[1] = 'Lelang Umum'; 
		$metode_pengadaan[2] = 'Lelang Sederhana'; 
		$metode_pengadaan[3] = 'Lelang Terbatas';  
		$metode_pengadaan[4] = 'Seleksi Umum';  
		$metode_pengadaan[5] = 'Seleksi Sederhana'; 
		$metode_pengadaan[6] = 'Pemilihan Langsung'; 
		$metode_pengadaan[7] = 'Penunjukan Langsung';  
		$metode_pengadaan[8] = 'Pengadaan Langsung';  
		$metode_pengadaan[9] = 'e-Purchasing'; 

		foreach($rsdummy as $row) {
			$sirupID = $row->sirupID;
			$ocid = env('OCID') . $sirupID ;

			$suppliers = array();
			$data['ocid'] 		= $ocid;
			$data['uri'] 		= env('LINK_SIRUP').$year."/".$sirupID;
			$data['title'] 		= $row->namapekerjaan; 
			$data['kode']		= $row->kode;
			$data['activity']	= $row->namakegiatan;
			$data['sirupID'] 	= $sirupID;
			$data['SKPD']		= "";
			$data['anggaran']	= "";
			$data['hps']		= $row->hps;
			$data['nilai_penawaran']	= "";
			$data['nilai_nego']			= $row->nilai_nego;
			$data['suppliers']			= $suppliers;

			$data['procurementMethod']		= "";
			$data['procurementMethodDetails'] = "";
			$data['awardCriteria']		= "";
			$data['dateSigned'] = "";
			$data['contract']	= array(
					'startDate' => "",
					'endDate' => ""
			);
			$data['created_at']		= "";
			$data['updated_at']		= "";
			array_push($rowdata, $data);
        }

		$results = $rowdata;

		return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
	}
}
