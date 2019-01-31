<?php

namespace App\Http\Controllers;

use App\Illuminate\Pagination\ArrayLengthAwarePaginator;
use Illuminate\Http\Request;
use App\Sirup;
use App\Paketlng;
use App\Paketpl;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use NestedJsonFlattener\Flattener\Flattener;

class ApiBIRMS extends Controller
{
    public function contractsAll()
    {
        $ocid = env('OCID');
		$results = Sirup::selectRaw('sirupID, 
							CONCAT(\'$ocid.\',\'s-\',tahun,\'-\',sirupID) AS ocid,
							tahun, nama, pagu')
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
     * @return ArrayLengthAwarePaginator
     */
    public function arrayPaginator($array, $request)
    {
        $page = Input::get('page', 1);
        $perPage = Input::get('per_page', env('JSON_RESULTS_PER_PAGE', 40));
        $offset = ($page * $perPage) - $perPage;

        return new ArrayLengthAwarePaginator(array_slice($array, $offset, $perPage, true),
            count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
    }

    public function contractsPerYear($year)
    {
        return $this->itemsPerYear($year,"newcontract");
    }

    public function packagesPerYear($year)
    {
        return $this->itemsPerYear($year,"package");
    }


    public function itemsPerYear($year, $urlType)
    {
		//$results = Sirup::where("tahun", $year)->paginate(100);
		$ocid = env('OCID');

		$dbplanning = env('DB_PLANNING');

		$sql = 'SELECT
		CONCAT("'.$ocid.'","s-",tahun,"-",sirupID) AS ocid,
		tahun AS year,
		nama AS title,
		CONCAT("'.env('API_ENDPOINT').'", "/'.$urlType.'/", "'.env('OCID').'","s-",tahun,"-",sirupID) AS uri,
		pagu AS value
	FROM
	'.$dbplanning.'.tbl_sirup WHERE tahun = '.$year.' 
		AND pagu <> 0 AND metode_pengadaan IN (1,2,3,4,5,6,10,11,12)
		AND isswakelola = 0 
	UNION 
	SELECT
		CONCAT("'.$ocid.'","b-",'.$year.',"-",tbl_pekerjaan.pekerjaanID) AS ocid,
		'.$year.' AS year,
		namapekerjaan AS title,
		CONCAT("'.env('API_ENDPOINT').'", "/'.$urlType.'/", "'.env('OCID').'","b-",'.$year.',"-",tbl_pekerjaan.pekerjaanID) AS uri,
		anggaran AS value
	FROM
	'.$dbplanning.'.tbl_pekerjaan 
	WHERE tahun = '.$year.' AND iswork = 1';
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
					TRIM(identity_no) AS nip ,
					fullname AS nama ,
					ringkasan AS kewenangan ,
					tglsk ,
					nosk ,
					tbl_skpd.unitID ,
					tbl_skpd.nama AS skpdnama
				FROM
					'.$dbplanning.'.tr_sk_user
				LEFT OUTER JOIN '.$dbplanning.'.tbl_sk ON tr_sk_user.skID = tbl_sk.skID 
				LEFT OUTER JOIN '.$dbplanning.'.tbl_sk_tipe ON tbl_sk.sktipeID = tbl_sk_tipe.sktipeID			
				LEFT OUTER JOIN '.$dbmain.'.tbl_user ON tr_sk_user.usrID = tbl_user.usrID
				LEFT OUTER JOIN '.$dbmain.'.tbl_skpd ON tbl_sk.skpdID = tbl_skpd.skpdID
				WHERE YEAR(tglsk) = '.$year.' AND tbl_sk.sktipeID = '.$sktipeID.' AND identity_no <> \'\' 
				GROUP BY nip, fullname, kewenangan, tglsk, nosk, unitID, skpdnama
				ORDER BY unitID, TRIM(nip)';
		$results = $this->arrayPaginator(DB::select($sql), request());
		return response()
				->json($results)
				->header('Access-Control-Allow-Origin', '*');	  
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

    /**
     * This is just the array-producing party of graph1 function. It is reused in both
     * graph1 and graph1_csv
     * @return array
     */
    public function graph1_array() {
        $sql = 'SELECT tahun, (nilaikontrak/1000000000) AS nilaikontrak FROM '.env('DB_CONTRACT').'.vlelang_bypaket ORDER BY tahun ASC';
        $rs1 = DB::select($sql);

        $rowdata = array();
        $data = array();
        foreach($rs1 as $row) {
            array_push($data, array($row->tahun, (float)$row->nilaikontrak));
        }
        array_push($rowdata, array("name"=>"Tender", "data"=> $data));

        $sql = 'SELECT tahun, (nilaikontrak/1000000000) AS nilaikontrak FROM '.env('DB_CONTRACT').'.vpl_bypaket ORDER BY tahun ASC';
        $rs1 = DB::select($sql);

        $data = array();
        foreach($rs1 as $row) {
            array_push($data, array($row->tahun, (float)$row->nilaikontrak));
        }
        array_push($rowdata, array("name"=>"Non Tender", "data"=> $data));
        $results = $rowdata;

        return $results;
    }

	/*--- Start Data Statistic ---*/
	public function graph1()
	{
    	return response()
    			->json($this->graph1_array())
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
						AND (`tlelangumum`.`skpdID` <> 0)
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
							(`tpengadaan`.`pekerjaanstatus` = 7)
							AND (`tpengadaan`.`ta` = '.$year.')
							AND (`tpengadaan`.`skpdID` <> 0)
						)
					GROUP BY
						`tpengadaan`.`skpdID` ,
						'.env('DB_PRIME').'.`tbl_skpd`.`nama`,
						`ta`
					ORDER BY
						`nilai_kontrak` DESC
					LIMIT 10';
					//echo $sql;
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
		array_push($rowdata, array("name"=>"Tender", "data"=> $data));

		$sql = 'SELECT tahun, paket FROM '.env('DB_CONTRACT').'.vpl_bypaket ORDER BY tahun ASC';
		$rs2 = DB::select($sql);

		$data = array();
		foreach($rs2 as $row) {
			array_push($data, array($row->tahun, (int)$row->paket));
		}
		array_push($rowdata, array("name"=>"Non Tender", "data"=> $data));
		$results = $rowdata;

    	return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
	}

    /**
     * Converts nested array to flatten array using Flattener and
     * returns as BinaryFileResponse. Deletes file after is downloaded.
     * You can reuse this function to make csv downloads for all json functions here
     * @param $filePrefix
     * @param $nested_array
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
	public function download_nested_array_csv($filePrefix, $nested_array) {
        $flattener = new Flattener();
        $flattener->setArrayData($nested_array);
        $tempFileName = sys_get_temp_dir().'/'.$filePrefix.'-'.rand();
        $flattener->writeCsv($tempFileName);
        return response()->download($tempFileName.".csv")->deleteFileAfterSend(true);
    }

    /**
     * Produces a csv download for graph1
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
	public function graph_csv1()
	{
        $sql = 'SELECT tahun, (nilaikontrak/1000000000) AS nilaikontrak FROM '.env('DB_CONTRACT').'.vlelang_bypaket ORDER BY tahun ASC';
        $rs1 = DB::select($sql);

        $rowdata = array();
        $data = array();

        foreach($rs1 as $row) {
            array_push($data, array($row->tahun));
        }
        array_push($rowdata, array("name"=>"Year", "data"=> $data));

        $data = array();
        foreach($rs1 as $row) {
            array_push($data, array((float)$row->nilaikontrak));
        }
        array_push($rowdata, array("name"=>"Lelang", "data"=> $data));

        $sql = 'SELECT tahun, (nilaikontrak/1000000000) AS nilaikontrak FROM '.env('DB_CONTRACT').'.vpl_bypaket ORDER BY tahun ASC';
        $rs1 = DB::select($sql);

        $data = array();
        foreach($rs1 as $row) {
            array_push($data, array((float)$row->nilaikontrak));
        }
        array_push($rowdata, array("name"=>"Pengadaan Langsung", "data"=> $data));
        $results = $rowdata;

        //return $results;
        //return $this->download_nested_array_csv('lelang',$results);
        return $this->download_nested_array_csv('lelang',$this->graph1_array());
	}

	public function graph_csv2()
	{
		//TODO :
		return "CSV SKPD";
	}

	public function graph_csv3()
	{
		//TODO :
		return "CSV Non Competitive";
	}

	public function graph_csv4()
	{
		//TODO :
		return "CSV Total Procurement";
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
								$sql .= " AND (`tpengadaan`.`namapekerjaan` LIKE '%$q%' OR `tbl_skpd`.nama LIKE  '%$q%')"; 
							}

							if (!empty($tahun)) {
								$sql .= " AND `tpengadaan`.ta = $tahun "; 
							}

							/*if (!empty($skpdID)) {
								$sql .= " AND `tpengadaan`.skpdID = $skpdID"; 
							}*/

							if (!empty($klasifikasi)) {
								$sql .= " AND LEFT(`tklasifikasi`.kode,2) = $klasifikasi"; 
							}

							if (!empty($min)) {
								$sql .= " AND (`tpengadaan`.anggaran >= $min OR `tpengadaan`.nilai_nego >= $min) "; 
							}

							if (!empty($max)) {
								$sql .= " AND (`tpengadaan`.anggaran <= $max OR `tpengadaan`.nilai_nego <= $max) "; 
							}
					echo $sql;
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

	public function jenis_belanja($jenis) {
        switch ($jenis) {
            case 1:
				$jenis_belanja = 'Barang/Jasa'; 
				break;
			case 2:
				$jenis_belanja = 'Modal'; 
				break;
			default:
                $jenis_belanja = '';
        }		
		return $jenis_belanja;
	}
	
	public function jenis_pengadaan($jenis) {
		switch ($jenis) {
            case 1:
				$jenis_pengadaan = 'Barang'; 
				break;
			case 2:
				$jenis_pengadaan = 'Pekerjaan Konstruksi'; 
				break;
			case 3:
				$jenis_pengadaan = 'Jasa Konsultansi'; 
				break;
			case 4:
				$jenis_pengadaan = 'Jasa Lainnya'; 
				break;	
			default:
                $jenis_pengadaan = '';
        }		
		return $jenis_pengadaan;
	}

	public function metode_pengadaan($metode) {
		switch ($metode) {
            case 1:
				$metode_pengadaan = 'Lelang Umum'; 
				break;
			case 2:
				$metode_pengadaan = 'Lelang Sederhana'; 
				break;
			case 3:
				$metode_pengadaan = 'Lelang Terbatas'; 
				break;
			case 4:
				$metode_pengadaan = 'Seleksi Umum'; 
				break;
			case 5:
				$metode_pengadaan = 'Seleksi Sederhana'; 
				break;
			case 6:
				$metode_pengadaan = 'Pemilihan Langsung'; 
				break;
			case 7:
				$metode_pengadaan = 'Penunjukan Langsung'; 
				break;
			case 8:
				$metode_pengadaan = 'Pengadaan Langsung'; 
				break;
			case 9:
				$metode_pengadaan = 'e-Purchasing'; 
				break;				
			default:
                $metode_pengadaan = '';
        }		
		return $metode_pengadaan;
	}
		
	public function get_program($year, $kode) {
		$dbplanning = env('DB_PLANNING');

		$sql = "SELECT Ket_Program FROM ".$dbplanning.".ta_program WHERE Tahun = ".$year." AND 
				ta_program.ID_Prog = CONCAT(SUBSTRING_INDEX('".$kode."', '.', 1), SUBSTRING_INDEX(SUBSTRING_INDEX('".$kode."', '.', 2), '.', -1)) AND
				ta_program.Kd_Urusan = SUBSTRING_INDEX(SUBSTRING_INDEX('".$kode."', '.', 3), '.', -1) AND 
				ta_program.Kd_Bidang = SUBSTRING_INDEX(SUBSTRING_INDEX('".$kode."', '.', 4), '.', -1) AND 
				ta_program.Kd_Unit = SUBSTRING_INDEX(SUBSTRING_INDEX('".$kode."', '.', 5), '.', -1) AND
				ta_program.Kd_Sub = SUBSTRING_INDEX(SUBSTRING_INDEX('".$kode."', '.', 6), '.', -1) AND
				ta_program.Kd_Prog = SUBSTRING_INDEX(SUBSTRING_INDEX('".$kode."', '.', 7), '.', -1) ";
		$rsprogram = DB::select($sql);
		
		if (sizeof($rsprogram) != 0) {
			$rsprogram = $rsprogram[0];
			$namaprogram = $rsprogram->Ket_Program;
		} else {
			$namaprogram = "";
		}
		return $namaprogram;
	}				

	/*--- Recent Data ---*/
	public function get_recent_perencanaan() 
	{
		$dbplanning = env('DB_PLANNING');
        $dbcontract = env('DB_CONTRACT');
        $dbprime    = env('DB_PRIME');

		$year = date('Y');

		$sql = 'SELECT COUNT(*) AS jumlah FROM tbl_sirup WHERE tahun = '.$year.' AND sirupID = 0';
		$rscheck = DB::select($sql);
		if ($rscheck[0]->jumlah == 0) {
			$year = date('Y') - 1;
		}

		$sql = 'SELECT
						CONCAT("'.env('OCID').'","s-",tahun,"-",tbl_sirup.sirupID) AS ocid,
						NULL AS koderekening,
						tbl_sirup.sirupID,
						tahun,
						nama,
						pagu,
						sumber_dana_string,
						jenis_belanja,
						jenis_pengadaan,
						metode_pengadaan,
						NULL AS procurementMethodDetails,
						NULL AS awardCriteria,
						jenis,
						tanggal_awal_pengadaan,
						tanggal_akhir_pengadaan,
						tanggal_awal_pekerjaan,
						tanggal_akhir_pekerjaan,
						id_satker,
						kldi,
						satuan_kerja,
						lokasi,
						isswakelola, 
						NULL AS isready,
						tlelangumum.pekerjaanstatus,
						NULL AS created_at,
						NULL AS updated_at
				FROM
				'.$dbplanning.'.tbl_sirup
				LEFT JOIN '.$dbcontract.'.tlelangumum ON tbl_sirup.sirupID = tlelangumum.sirupID 
				WHERE
					tbl_sirup.tahun = '.$year.' 
					AND pagu <> 0  
                    AND tlelangumum.hps <> 0 
                    AND tlelangumum.penawaran <> 0 
                    AND tlelangumum.nilai_nego <> 0 
                    AND tlelangumum.pekerjaanstatus <= 3
                    AND (NOT ISNULL(tlelangumum.namakegiatan) AND TRIM(tlelangumum.namakegiatan) <> "")	
                    AND metode_pengadaan IN (1,2,3,4,5,6,10,11,12) AND isswakelola = 0

					UNION
					SELECT
					CONCAT( "'.env('OCID').'", "b-", tbl_pekerjaan.tahun, "-", tbl_pekerjaan.pekerjaanID  ) AS ocid,
					kodepekerjaan AS koderekening,
					sirupID,
					tbl_pekerjaan.tahun ,
					tbl_pekerjaan.namapekerjaan AS nama ,
					tbl_pekerjaan.anggaran AS pagu ,
					tbl_sumberdana.sumberdana AS sumber_dana_string ,
					1 AS jenis_belanja ,
					tbl_metode.jenisID AS jenis_pengadaan ,
					(
						CASE
						WHEN tbl_metode.nama = "Belanja Sendiri" THEN
							9
						WHEN tbl_metode.nama = "Kontes / Sayembara" THEN
							10
						WHEN tbl_metode.nama = "Pelelangan Sederhana" THEN
							2
						WHEN tbl_metode.nama = "Pelelangan Umum" THEN
							1
						WHEN tbl_metode.nama = "Pembelian Secara Elektronik" THEN
							9
						WHEN tbl_metode.nama = "Pemilihan Langsung" THEN
							6
						WHEN tbl_metode.nama = "Pengadaan Langsung" THEN
							8
						WHEN tbl_metode.nama = "Penunjukan Langsung" THEN
							7
						WHEN tbl_metode.nama = "Swakelola" THEN
							21
						ELSE
							0
						END
					) AS metode_pengadaan ,
					NULL AS procurementMethodDetails,
					NULL AS awardCriteria,
					2 AS jenis ,
					pilih_start AS tanggal_awal_pengadaan ,
					pilih_end AS tanggal_akhir_pengadaan ,
					laksana_start AS tanggal_awal_pekerjaan ,
					laksana_end AS tanggal_akhir_pekerjaan ,
					satker AS id_satker ,
					"Kota Bandung" AS kldi ,
					tbl_skpd.nama AS satuan_kerja ,
					tbl_skpd.alamat AS lokasi ,
					IF (tbl_metode.nama = "Swakelola" , 1 , 0) AS isswakelola,
					IF (ISNULL(tpekerjaan.pid),0,1) AS isready, 
					tpekerjaan.pekerjaanstatus,
					tbl_pekerjaan.created AS created_at,
					tbl_pekerjaan.updated AS updated_at
				FROM
					'.$dbplanning.'.tbl_pekerjaan
				LEFT JOIN '.$dbplanning.'.tbl_sumberdana ON tbl_pekerjaan.sumberdanaID = tbl_sumberdana.sumberdanaID
				LEFT JOIN '.$dbprime.'.tbl_skpd ON tbl_pekerjaan.skpdID = tbl_skpd.skpdID
				LEFT JOIN '.$dbplanning.'.tbl_metode ON tbl_pekerjaan.metodeID = tbl_metode.metodeID
				LEFT JOIN '.$dbcontract.'.tpekerjaan ON tbl_pekerjaan.pekerjaanID = tpekerjaan.pekerjaanID
				WHERE 
				tbl_pekerjaan.tahun = '.$year.' AND 
				sirupID = 0 AND 
				iswork = 1 ';
				//AND tpekerjaan.pekerjaanstatus <= 3
				$sql .= ' ORDER BY tanggal_awal_pengadaan DESC LIMIT 10';
		$rsdummy = DB::select($sql);

		$rowdata = array();
		$data = array();

		foreach($rsdummy as $row) {
			$pieces = explode("-", $row->ocid);
        	$source    = $pieces[2]; // s = sirup.lkpp.go.id. b = birms.bandung.go.id
			
			$data['ocid'] 		= $row->ocid;
			if ($source == "s") {
				$data['uri'] 		= env('LINK_SIRUP18').$row->sirupID;
			} else {
				$data['uri'] 		= "";
			}

			$data['title'] 		= $row->nama; 
			$data['koderekening'] = $row->koderekening;
			$data['project'] 	= $this->get_program($row->tahun, $row->koderekening);
			$data['sirupID'] 	= $row->sirupID;
			$data['SKPD']		= $row->satuan_kerja;
			$data['budget']		= array(
					'description' =>$row->sumber_dana_string,
					'amount' => array(
						'amount' => $row->pagu,
						'currency' => env('CURRENCY')
					),
					'uri' => $data['uri']
				);
			if ($row->jenis_pengadaan != "") {	
				$data['mainProcurementCategory']	= $this->jenis_pengadaan($row->jenis_pengadaan);
			} else {
				$data['mainProcurementCategory']	= "";
			}
			$data['procurementMethod']				= $row->metode_pengadaan;
			if ($row->metode_pengadaan != 0) {
				$data['procurementMethodDetails']	= $this->metode_pengadaan($row->metode_pengadaan);
			} else {
				$data['procurementMethodDetails']	= "";
			}
			$data['awardCriteria']					= "priceOnly"; //To Do List Check Source
			$data['tender']		= array(
					'startDate' => $row->tanggal_awal_pengadaan,
					'endDate' => $row->tanggal_akhir_pengadaan
			);
			$data['contract']	= array(
					'startDate' => $row->tanggal_awal_pekerjaan,
					'endDate' => $row->tanggal_akhir_pekerjaan
			);
			$data['created_at']		= $row->created_at;
			$data['updated_at']		= $row->updated_at;
			array_push($rowdata, $data);
        }

		$results = $rowdata;

		//$results = $this->arrayPaginator($rowdata, request());
    	return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
	}

	function get_recent_pemilihan() 
    {
        $dbplanning = env('DB_PLANNING');
        $dbcontract = env('DB_CONTRACT');
        $dbprime    = env('DB_PRIME');
        
        $year = date('Y');
        $sql = 'SELECT
                    CONCAT("'.env('OCID').'","s-",tahun,"-",tbl_sirup.sirupID) AS ocid,
					tbl_sirup.sirupID,
					tlelangumum.skpdID,
                    satuan_kerja,
                    tahun,
                    tlelangumum.kode AS koderekening,
                    lls_id AS lelangID,
                    namakegiatan,
                    nama AS title,
                    tanggal_awal_pekerjaan,
                    tanggal_akhir_pekerjaan,
                    metode_pengadaan,
                    pagu,
                    hps,
                    jumlah_peserta,
                    jenis, 
                    jenis_belanja,
                    jenis_pengadaan,
                    penawaran,
                    nilai_nego,
					tlelangumum.pekerjaanstatus,
					tlelangumum.created,
                    tlelangumum.updated
                FROM
                    '.$dbplanning.'.tbl_sirup                
                    LEFT JOIN '.$dbcontract.'.tlelangumum ON tbl_sirup.sirupID = tlelangumum.sirupID 
                WHERE
                    tbl_sirup.tahun = '.$year.'  
                    AND tlelangumum.hps <> 0 
                    AND tlelangumum.penawaran <> 0 
                    AND tlelangumum.nilai_nego <> 0 
                    AND tlelangumum.pekerjaanstatus = 4
                    AND (NOT ISNULL(tlelangumum.namakegiatan) AND TRIM(tlelangumum.namakegiatan) <> "")	
                    AND metode_pengadaan IN (1,2,3,4,5,6,10,11,12)
                UNION 
                SELECT
                        CONCAT("'.env('OCID').'","b-",tahun,"-",tbl_pekerjaan.pekerjaanID) AS ocid,
						tbl_pekerjaan.pekerjaanID AS sirupID, 
						tbl_pekerjaan.skpdID,
                        tbl_skpd.nama AS satuan_kerja,
                        tahun,
                        tbl_pekerjaan.kodepekerjaan AS koderekening,
                        tbl_pekerjaan.pekerjaanID AS lelangID,
                        tpekerjaan.namakegiatan,
                        tbl_pekerjaan.namapekerjaan AS title,
                        tbl_pekerjaan.pilih_start AS tanggal_awal_pekerjaan,
                        tbl_pekerjaan.pilih_end AS tanggal_akhir_pekerjaan,
                        (
                            CASE
                            WHEN tbl_metode.nama = "Belanja Sendiri" THEN
                                9
                            WHEN tbl_metode.nama = "Kontes / Sayembara" THEN
                                10
                            WHEN tbl_metode.nama = "Pelelangan Sederhana" THEN
                                2
                            WHEN tbl_metode.nama = "Pelelangan Umum" THEN
                                1
                            WHEN tbl_metode.nama = "Pembelian Secara Elektronik" THEN
                                9
                            WHEN tbl_metode.nama = "Pemilihan Langsung" THEN
                                6
                            WHEN tbl_metode.nama = "Pengadaan Langsung" THEN
                                8
                            WHEN tbl_metode.nama = "Penunjukan Langsung" THEN
                                7
                            WHEN tbl_metode.nama = "Swakelola" THEN
                                21
                            ELSE
                                0
                            END
                        ) AS metode_pengadaan ,
                        tbl_pekerjaan.anggaran AS pagu,
                        tpekerjaan.hps,
                        1 AS jumlah_peserta,
                        NULL AS jenis, 
                        1 AS jenis_belanja ,
                        tbl_metode.jenisID AS jenis_pengadaan,
					    tpengadaan_pemenang.nilai AS penawaran,
                        tpengadaan.nilai_nego,
						tpengadaan.pekerjaanstatus,
						tpengadaan.created,
                        tpengadaan.updated
                FROM
                    '.$dbplanning.'.tbl_pekerjaan 
                    LEFT JOIN '.$dbcontract.'.tpekerjaan ON tbl_pekerjaan.pekerjaanID = tpekerjaan.pekerjaanID
                    LEFT JOIN '.$dbcontract.'.tpengadaan ON tpekerjaan.pid = tpengadaan.pid
                    LEFT JOIN '.$dbcontract.'.tpengadaan_pemenang ON tpengadaan.pgid = tpengadaan_pemenang.pgid
                    LEFT JOIN '.$dbprime.'.tbl_skpd ON tbl_pekerjaan.skpdID = tbl_skpd.skpdID
                    LEFT JOIN '.$dbplanning.'.tbl_metode ON tbl_pekerjaan.metodeID = tbl_metode.metodeID
                    WHERE tahun = '.$year.' AND iswork = 1 AND tpengadaan.pekerjaanstatus = 4
                ORDER BY updated DESC, created DESC LIMIT 10';
        //die($sql);
        $rspengadaan = DB::select($sql);

		$rowdata = array();
		$data = array();

		foreach($rspengadaan as $row) {
			$pieces = explode("-", $row->ocid);
			$source    = $pieces[2];

            $data['ocid'] 		= $row->ocid;
            if ($source == "s") {
				$data['uri'] 		= env('LINK_SIRUP18').$row->sirupID;
			} else {
				$data['uri'] 		= "";
			}
            $data['title'] 		    = $row->title; 
            $data['namakegiatan']   = $row->namakegiatan;
			$data['koderekening']   = $row->koderekening;
            $data['project'] 	    = $this->get_program($row->tahun, $row->koderekening);
			
            $data['sirupID'] 	    = $row->sirupID;
            $data['SKPD']		    = $row->satuan_kerja;
            $data['anggaran']       = $row->pagu;
            $data['hps']            = $row->hps;
            $data['nilai_penawaran']= $row->penawaran;
            
            $data['nilai_nego']     = $row->nilai_nego;
            $data['jumlah_peserta'] = $row->jumlah_peserta;
            $data['procurementMethod']				= $row->metode_pengadaan;
			if ($row->metode_pengadaan != 0) {
				$data['procurementMethodDetails']		= $this->metode_pengadaan($row->metode_pengadaan);
			} else {
				$data['procurementMethodDetails']		= "";
            }
            $data['awardCriteria']	   = "priceOnly"; //To Do List Check Source
            $data['dateSigned']        = "";
            $data['contract']	= array(
                'startDate' => $row->tanggal_awal_pekerjaan,
                'endDate' => $row->tanggal_akhir_pekerjaan
            );
            $data['updated']		= $row->updated;

			array_push($rowdata, $data);
        }

		$results = $rowdata;

		return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
    }

	public function get_recent_pemenang() 
	{
		$dbplanning = env('DB_PLANNING');
        $dbcontract = env('DB_CONTRACT');
        $dbprime    = env('DB_PRIME');
        
        $year = date('Y');
        $sql = 'SELECT
                    CONCAT("'.env('OCID').'","s-",tahun,"-",tbl_sirup.sirupID) AS ocid,
					tbl_sirup.sirupID,
					tlelangumum.skpdID,
                    satuan_kerja,
                    tahun,
                    tlelangumum.kode AS koderekening,
                    lls_id AS lelangID,
                    namakegiatan,
                    nama AS title,
                    tanggal_awal_pekerjaan,
                    tanggal_akhir_pekerjaan,
                    metode_pengadaan,
                    pagu,
                    hps,
                    jumlah_peserta,
                    jenis, 
                    jenis_belanja,
					jenis_pengadaan,
					pemenang AS perusahaannama,
					pemenangalamat AS perusahaanalamat,
					pemenangnpwp AS perusahaannpwp,
                    penawaran,
                    nilai_nego,
					tlelangumum.pekerjaanstatus,
					tlelangumum.created,
                    tlelangumum.updated
                FROM
                    '.$dbplanning.'.tbl_sirup                
                    LEFT JOIN '.$dbcontract.'.tlelangumum ON tbl_sirup.sirupID = tlelangumum.sirupID 
                WHERE
                    tbl_sirup.tahun = '.$year.'  
                    AND tlelangumum.hps <> 0 
                    AND tlelangumum.penawaran <> 0 
                    AND tlelangumum.nilai_nego <> 0 
                    AND tlelangumum.pekerjaanstatus = 7
                    AND (NOT ISNULL(tlelangumum.namakegiatan) AND TRIM(tlelangumum.namakegiatan) <> "")	
                    AND metode_pengadaan IN (1,2,3,4,5,6,10,11,12)
                UNION 
                SELECT
                        CONCAT("'.env('OCID').'","b-",tahun,"-",tbl_pekerjaan.pekerjaanID) AS ocid,
						tbl_pekerjaan.pekerjaanID AS sirupID, 
						tbl_pekerjaan.skpdID,
                        tbl_skpd.nama AS satuan_kerja,
                        tahun,
                        tbl_pekerjaan.kodepekerjaan AS koderekening,
                        tbl_pekerjaan.pekerjaanID AS lelangID,
                        tpekerjaan.namakegiatan,
                        tbl_pekerjaan.namapekerjaan AS title,
                        tbl_pekerjaan.pilih_start AS tanggal_awal_pekerjaan,
                        tbl_pekerjaan.pilih_end AS tanggal_akhir_pekerjaan,
                        (
                            CASE
                            WHEN tbl_metode.nama = "Belanja Sendiri" THEN
                                9
                            WHEN tbl_metode.nama = "Kontes / Sayembara" THEN
                                10
                            WHEN tbl_metode.nama = "Pelelangan Sederhana" THEN
                                2
                            WHEN tbl_metode.nama = "Pelelangan Umum" THEN
                                1
                            WHEN tbl_metode.nama = "Pembelian Secara Elektronik" THEN
                                9
                            WHEN tbl_metode.nama = "Pemilihan Langsung" THEN
                                6
                            WHEN tbl_metode.nama = "Pengadaan Langsung" THEN
                                8
                            WHEN tbl_metode.nama = "Penunjukan Langsung" THEN
                                7
                            WHEN tbl_metode.nama = "Swakelola" THEN
                                21
                            ELSE
                                0
                            END
                        ) AS metode_pengadaan ,
                        tbl_pekerjaan.anggaran AS pagu,
                        tpekerjaan.hps,
                        1 AS jumlah_peserta,
                        NULL AS jenis, 
                        1 AS jenis_belanja ,
						tbl_metode.jenisID AS jenis_pengadaan,
						tpengadaan_pemenang.perusahaannama,
						tpengadaan_pemenang.perusahaanalamat,
						tpengadaan_pemenang.perusahaannpwp,						
					    tpengadaan_pemenang.nilai AS penawaran,
                        tpengadaan.nilai_nego,
						tpengadaan.pekerjaanstatus,
						tpengadaan.created,
                        tpengadaan.updated
                FROM
                    '.$dbplanning.'.tbl_pekerjaan 
                    LEFT JOIN '.$dbcontract.'.tpekerjaan ON tbl_pekerjaan.pekerjaanID = tpekerjaan.pekerjaanID
                    LEFT JOIN '.$dbcontract.'.tpengadaan ON tpekerjaan.pid = tpengadaan.pid
                    LEFT JOIN '.$dbcontract.'.tpengadaan_pemenang ON tpengadaan.pgid = tpengadaan_pemenang.pgid
                    LEFT JOIN '.$dbprime.'.tbl_skpd ON tbl_pekerjaan.skpdID = tbl_skpd.skpdID
                    LEFT JOIN '.$dbplanning.'.tbl_metode ON tbl_pekerjaan.metodeID = tbl_metode.metodeID
                    WHERE tahun = '.$year.' AND iswork = 1 AND tpengadaan.pekerjaanstatus = 7
                ORDER BY updated DESC, created DESC LIMIT 10';
        //die($sql);
        $rspengadaan = DB::select($sql);

		$rowdata = array();
		$data = array();

		foreach($rspengadaan as $row) {
			$pieces = explode("-", $row->ocid);
			$source    = $pieces[2];

            $data['ocid'] 		= $row->ocid;
            if ($source == "s") {
				$data['uri'] 		= env('LINK_SIRUP18').$row->sirupID;
			} else {
				$data['uri'] 		= "";
			}
            $data['title'] 		    = $row->title; 
            $data['namakegiatan']   = $row->namakegiatan;
			$data['koderekening']   = $row->koderekening;
            $data['project'] 	    = $this->get_program($row->tahun, $row->koderekening);
			
            $data['sirupID'] 	    = $row->sirupID;
            $data['SKPD']		    = $row->satuan_kerja;
            $data['anggaran']       = $row->pagu;
            $data['hps']            = $row->hps;
			$data['nilai_penawaran']= $row->penawaran;
			
			$data['perusahaannama']	= $row->perusahaannama;
			$data['perusahaanalamat']= $row->perusahaanalamat;
			$data['perusahaannpwp']	= $row->perusahaannpwp;
            
            $data['nilai_nego']     = $row->nilai_nego;
            $data['jumlah_peserta'] = $row->jumlah_peserta;
            $data['procurementMethod']				= $row->metode_pengadaan;
			if ($row->metode_pengadaan != 0) {
				$data['procurementMethodDetails']		= $this->metode_pengadaan($row->metode_pengadaan);
			} else {
				$data['procurementMethodDetails']		= "";
            }
            $data['awardCriteria']					= "priceOnly"; //To Do List Check Source
            $data['dateSigned']        = "";
            $data['contract']	= array(
                'startDate' => $row->tanggal_awal_pekerjaan,
                'endDate' => $row->tanggal_akhir_pekerjaan
            );
            $data['updated']		= $row->updated;

			array_push($rowdata, $data);
        }

		$results = $rowdata;

		return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
	}

	public function get_recent_kontrak() 
	{
		$dbplanning = env('DB_PLANNING');
        $dbcontract = env('DB_CONTRACT');
        $dbprime    = env('DB_PRIME');
        
        $year = date('Y');
        $sql = 'SELECT
                    CONCAT("'.env('OCID').'","s-",tahun,"-",tbl_sirup.sirupID) AS ocid,
					tbl_sirup.sirupID,
					tlelangumum.skpdID,
                    satuan_kerja,
                    tahun,
                    tlelangumum.kode AS koderekening,
                    lls_id AS lelangID,
                    namakegiatan,
                    nama AS title,
                    tanggal_awal_pekerjaan,
                    tanggal_akhir_pekerjaan,
                    metode_pengadaan,
                    pagu,
                    hps,
                    jumlah_peserta,
                    jenis, 
                    jenis_belanja,
					jenis_pengadaan,
					pemenang AS perusahaannama,
					pemenangalamat AS perusahaanalamat,
					pemenangnpwp AS perusahaannpwp,
                    penawaran,
                    nilai_nego,
					tlelangumum.pekerjaanstatus,
					tlelangumum.created,
                    tlelangumum.updated
                FROM
                    '.$dbplanning.'.tbl_sirup                
                    LEFT JOIN '.$dbcontract.'.tlelangumum ON tbl_sirup.sirupID = tlelangumum.sirupID 
                WHERE
                    tbl_sirup.tahun = '.$year.'  
                    AND tlelangumum.hps <> 0 
                    AND tlelangumum.penawaran <> 0 
                    AND tlelangumum.nilai_nego <> 0 
                    AND tlelangumum.pekerjaanstatus = 7
                    AND (NOT ISNULL(tlelangumum.namakegiatan) AND TRIM(tlelangumum.namakegiatan) <> "")	
                    AND metode_pengadaan IN (1,2,3,4,5,6,10,11,12)
                UNION 
                SELECT
                        CONCAT("'.env('OCID').'","b-",tahun,"-",tbl_pekerjaan.pekerjaanID) AS ocid,
						tbl_pekerjaan.pekerjaanID AS sirupID, 
						tbl_pekerjaan.skpdID,
                        tbl_skpd.nama AS satuan_kerja,
                        tahun,
                        tbl_pekerjaan.kodepekerjaan AS koderekening,
                        tbl_pekerjaan.pekerjaanID AS lelangID,
                        tpekerjaan.namakegiatan,
                        tbl_pekerjaan.namapekerjaan AS title,
                        tbl_pekerjaan.pilih_start AS tanggal_awal_pekerjaan,
                        tbl_pekerjaan.pilih_end AS tanggal_akhir_pekerjaan,
                        (
                            CASE
                            WHEN tbl_metode.nama = "Belanja Sendiri" THEN
                                9
                            WHEN tbl_metode.nama = "Kontes / Sayembara" THEN
                                10
                            WHEN tbl_metode.nama = "Pelelangan Sederhana" THEN
                                2
                            WHEN tbl_metode.nama = "Pelelangan Umum" THEN
                                1
                            WHEN tbl_metode.nama = "Pembelian Secara Elektronik" THEN
                                9
                            WHEN tbl_metode.nama = "Pemilihan Langsung" THEN
                                6
                            WHEN tbl_metode.nama = "Pengadaan Langsung" THEN
                                8
                            WHEN tbl_metode.nama = "Penunjukan Langsung" THEN
                                7
                            WHEN tbl_metode.nama = "Swakelola" THEN
                                21
                            ELSE
                                0
                            END
                        ) AS metode_pengadaan ,
                        tbl_pekerjaan.anggaran AS pagu,
                        tpekerjaan.hps,
                        1 AS jumlah_peserta,
                        NULL AS jenis, 
                        1 AS jenis_belanja ,
						tbl_metode.jenisID AS jenis_pengadaan,
						tpengadaan_pemenang.perusahaannama,
						tpengadaan_pemenang.perusahaanalamat,
						tpengadaan_pemenang.perusahaannpwp,						
					    tpengadaan_pemenang.nilai AS penawaran,
                        tpengadaan.nilai_nego,
						tpengadaan.pekerjaanstatus,
						tpengadaan.created,
                        tpengadaan.updated
                FROM
                    '.$dbplanning.'.tbl_pekerjaan 
                    LEFT JOIN '.$dbcontract.'.tpekerjaan ON tbl_pekerjaan.pekerjaanID = tpekerjaan.pekerjaanID
                    LEFT JOIN '.$dbcontract.'.tpengadaan ON tpekerjaan.pid = tpengadaan.pid
                    LEFT JOIN '.$dbcontract.'.tpengadaan_pemenang ON tpengadaan.pgid = tpengadaan_pemenang.pgid
                    LEFT JOIN '.$dbprime.'.tbl_skpd ON tbl_pekerjaan.skpdID = tbl_skpd.skpdID
                    LEFT JOIN '.$dbplanning.'.tbl_metode ON tbl_pekerjaan.metodeID = tbl_metode.metodeID
                    WHERE tahun = '.$year.' AND iswork = 1 AND tpengadaan.pekerjaanstatus = 7
                ORDER BY updated DESC, created DESC LIMIT 10';
        //die($sql);
        $rspengadaan = DB::select($sql);

		$rowdata = array();
		$data = array();

		foreach($rspengadaan as $row) {
			$pieces = explode("-", $row->ocid);
			$source    = $pieces[2];

            $data['ocid'] 		= $row->ocid;
            if ($source == "s") {
				$data['uri'] 		= env('LINK_SIRUP18').$row->sirupID;
			} else {
				$data['uri'] 		= "";
			}
            $data['title'] 		    = $row->title; 
            $data['namakegiatan']   = $row->namakegiatan;
			$data['koderekening']   = $row->koderekening;
            $data['project'] 	    = $this->get_program($row->tahun, $row->koderekening);
			
            $data['sirupID'] 	    = $row->sirupID;
            $data['SKPD']		    = $row->satuan_kerja;
            $data['anggaran']       = $row->pagu;
            $data['hps']            = $row->hps;
			$data['nilai_penawaran']= $row->penawaran;
			
			$data['perusahaannama']	= $row->perusahaannama;
			$data['perusahaanalamat']= $row->perusahaanalamat;
			$data['perusahaannpwp']	= $row->perusahaannpwp;
            
            $data['nilai_nego']     = $row->nilai_nego;
            $data['jumlah_peserta'] = $row->jumlah_peserta;
            $data['procurementMethod']				= $row->metode_pengadaan;
			if ($row->metode_pengadaan != 0) {
				$data['procurementMethodDetails']		= $this->metode_pengadaan($row->metode_pengadaan);
			} else {
				$data['procurementMethodDetails']		= "";
            }
            $data['awardCriteria']					= "priceOnly"; //To Do List Check Source
            $data['dateSigned']        = "";
            $data['contract']	= array(
                'startDate' => $row->tanggal_awal_pekerjaan,
                'endDate' => $row->tanggal_akhir_pekerjaan
            );
            $data['updated']		= $row->updated;

			array_push($rowdata, $data);
        }

		$results = $rowdata;

		return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
	}

	public function get_skpd($year) 
	{
		$dbmain 	= env('DB_PRIME');
		$dbmain_prev= env('DB_PRIME_PREV');

		if ($year <= 2016) {
			$sql = 'SELECT unitID, satker, nama, singkatan, alamat, telepon, email FROM '.$dbmain_prev.'.tbl_skpd ';
		} else {
			$sql = 'SELECT unitID, satker, nama, singkatan, alamat, telepon, email FROM '.$dbmain.'.tbl_skpd ';
		}
		$results = $this->arrayPaginator(DB::select($sql), request());
    	return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');		
	}

	public function get_progres($year, $organization) 
	{
	    $dbplanning = env('DB_PLANNING');
	    $dbcontract = env('DB_CONTRACT');
		$dbmain 	= env('DB_PRIME');
		$dbmain_prev= env('DB_PRIME_PREV');

		$sql = "SELECT 
					CONCAT(REPLACE(tpekerjaan.tanggalrencana,'-',''),'.',tpengadaan.pid,'.',tpekerjaan.saltid) AS paketID, 
					tpengadaan.pgid, 
					tpengadaan.skpdID,
					tbl_skpd.nama AS skpdnama, 
					tpengadaan.kode AS koderekening,
					tpengadaan.namapekerjaan,
					tpengadaan.jenisID,
					tbl_jenis.nama AS jenis_pengadaan,
					tpengadaan.metodeID,
					tbl_metode.nama AS metode_pengadaan,
					tbl_user.identity_no AS ppk_nip,
					tbl_user.fullname AS ppk_nama,
					tpengadaan.lokasi, 
					tpekerjaan.lat,
					tpekerjaan.lng,
					tpengadaan.anggaran AS paguanggaran,
					tpengadaan.hps AS hps,
					tpengadaan.nilai_nego AS nilaikontrak,
					tpengadaan.pekerjaanstatus,
					tpengadaan_pemenang.perusahaannama,
					tpengadaan_pemenang.perusahaanalamat,
					tpengadaan_pemenang.perusahaannpwp,
					SUBSTRING_INDEX(SUBSTRING_INDEX(tprogress_pembayaran_bukti.isian,'|',5),'|',-1) AS perusahaanwakilnama,
					SUBSTRING_INDEX(SUBSTRING_INDEX(tprogress_pembayaran_bukti.isian,'|',6),'|',-1) AS perusahaanwakiljabatan,
					tkontrak_penunjukan.spk_nosurat AS spk_no,
					tkontrak_penunjukan.spk_tgl_surat AS spk_tgl,
					tkontrak_penunjukan.sp_nosurat AS sp_spmk_no,
					tkontrak_penunjukan.sp_tgl_surat AS sp_spmk_tgl,
					SUBSTRING_INDEX(SUBSTRING_INDEX(tprogress_serahterima.isian,'|',7),'|',-1) AS bapp_no,
					SUBSTRING_INDEX(SUBSTRING_INDEX(tprogress_serahterima.isian,'|',8),'|',-1) AS bapp_tgl,
					tprogress_serahterima.nosurat AS basthp_no,
					tprogress_serahterima.tgl_surat AS basthp_tgl,
					tprogress_pembayaran.nosurat AS bap_no,
					tprogress_pembayaran.tgl_surat AS bap_tgl,
					tprogress_pembayaran_bukti.nosurat AS kuitansi_no,
					tprogress_pembayaran_bukti.tgl_surat AS kuitansi_tgl,
					SUBSTRING_INDEX(SUBSTRING_INDEX(tprogress_pembayaran_bukti.isian,'|',1),'|',-1) AS suratjalan_no,
					SUBSTRING_INDEX(SUBSTRING_INDEX(tprogress_pembayaran_bukti.isian,'|',2),'|',-1) AS suratjalan_tgl,
					SUBSTRING_INDEX(SUBSTRING_INDEX(tprogress_pembayaran_bukti.isian,'|',3),'|',-1) AS faktur_no,
					SUBSTRING_INDEX(SUBSTRING_INDEX(tprogress_pembayaran_bukti.isian,'|',4),'|',-1) AS faktur_tgl
				FROM ".$dbcontract.".tpengadaan 
					LEFT JOIN ".$dbcontract.".tpekerjaan ON tpengadaan.pid = tpekerjaan.pid ";
				
				if ($year <= 2016) {
					$sql .= " LEFT JOIN ".$dbmain_prev.".tbl_skpd ON tpengadaan.skpdID = tbl_skpd.skpdID ";
					$sql .= " LEFT JOIN ".$dbmain_prev.".tbl_user ON tpengadaan.ppkm_userid = tbl_user.usrid ";
				} else {
					$sql .= " LEFT JOIN ".$dbmain.".tbl_skpd ON tpengadaan.skpdID = tbl_skpd.skpdID ";
					$sql .= " LEFT JOIN ".$dbmain.".tbl_user ON tpengadaan.ppkm_userid = tbl_user.usrid ";
				}

				$sql .= " LEFT JOIN ".$dbplanning.".tbl_jenis ON tpengadaan.jenisID = tbl_jenis.jenisID
					LEFT JOIN ".$dbplanning.".tbl_metode ON tpengadaan.metodeID = tbl_metode.metodeID
					LEFT JOIN ".$dbcontract.".tpengadaan_pemenang ON tpengadaan.pgid = tpengadaan_pemenang.pgid 
					LEFT JOIN ".$dbcontract.".tkontrak_penunjukan ON tpengadaan.pgid = tkontrak_penunjukan.pgid
					LEFT JOIN ".$dbcontract.".tprogress_serahterima ON tpengadaan.pgid = tprogress_serahterima.pgid
					LEFT JOIN ".$dbcontract.".tprogress_pembayaran ON tpengadaan.pgid = tprogress_pembayaran.pgid
					LEFT JOIN ".$dbcontract.".tprogress_pembayaran_bukti ON tpengadaan.pgid = tprogress_pembayaran_bukti.pgid
				WHERE tpengadaan.ta = ".$year." 
					AND tpengadaan.pekerjaanstatus = 7 ";
		if (strtoupper($organization) <> 'ALL') {
			$sql .= "AND tpengadaan.skpdID = (SELECT skpdID FROM ".$dbmain.".tbl_skpd WHERE nama = '".$organization."' OR unitID = '".$organization."')";
		}
		//die($sql);
		$results = $this->arrayPaginator(DB::select($sql), request());
    	return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');	
	}

	public function get_rencana($year, $organization)
    {
		$dbplanning = env('DB_PLANNING');
		$dbmain 	= env('DB_PRIME');

		if (strtoupper($organization) == 'ALL') {
			$sql = 'SELECT * FROM '.$dbplanning.'.tbl_sirup WHERE tahun = '.$year.' ';
		} else {
			$sql = 'SELECT nama FROM '.$dbmain.'.tbl_skpd WHERE unitID = \''.$organization.'\'';	
			$rsskpd = DB::select($sql);

			if (sizeof($rsskpd) != 0) {
				$rsskpd = $rsskpd[0];
				$organization = $rsskpd->nama;
			} 
			$sql = 'SELECT * FROM '.$dbplanning.'.tbl_sirup WHERE tahun = '.$year.' AND satuan_kerja = \''.$organization.'\'';
		}
		$results = $this->arrayPaginator(DB::select($sql), request());
    	return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
    }
}
