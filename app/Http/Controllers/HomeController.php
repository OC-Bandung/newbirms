<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    public function index()
    {
    	$dbecontract = env("DB_CONTRACT");
    	$dbprime = env("DB_PRIME");

    	/* Article ---- Start */
    	$sql = 	"SELECT tbl_post.pst_id,
					UPPER(tbl_post.title) AS title,
					tbl_post.summary,
					tbl_post.content,
					tbl_post.source,
					tbl_post.tags,
					tbl_post.poststatus,
					tbl_post.hits,
					tbl_postcontent.position,
					tbl_content.shortname,
					tbl_content.`name`,
					tbl_content.filename,
					tbl_post.created
				FROM $dbprime.tbl_post
					LEFT OUTER JOIN $dbprime.tbl_postcontent ON $dbprime.tbl_post.pst_id = $dbprime.tbl_postcontent.pst_id
					LEFT OUTER JOIN $dbprime.tbl_content ON $dbprime.tbl_postcontent.con_id = $dbprime.tbl_content.con_id
				WHERE poststatus = 2 AND $dbprime.tbl_content.filename <> '' ORDER BY $dbprime.tbl_post.created DESC LIMIT 10";
		$rspost = DB::select($sql);
    	/* Article ---- Finish */

    	/* Dashboard Data ---- Start --- Current Year */
    	$sql = "SELECT SUM(anggaran) AS anggaran, SUM(nilai_nego) AS nilai_nego, SUM(IF (NOT ISNULL(tkontrak.sp_nosurat),nilai_nego,0)) AS realisasikontrak, SUM(IF (NOT ISNULL(tprogress_pembayaran.tgl_surat),nilai_nego,0)) AS realisasikeuangan FROM $dbecontract.tlelangumum
				LEFT OUTER JOIN $dbecontract.tkontrak ON $dbecontract.tlelangumum.lgid = $dbecontract.tkontrak.lgid
				LEFT OUTER JOIN $dbecontract.tprogress_pembayaran ON $dbecontract.tlelangumum.lgid = $dbecontract.tprogress_pembayaran.lgid
				WHERE ta = YEAR(NOW())";
		$rspgd_select 			= DB::select($sql);
		$rspgd 					= json_decode(json_encode($rspgd_select), true);

		$sql = "SELECT SUM(tpengadaan.anggaran) AS anggaran, SUM(tpengadaan.nilai_nego) AS nilai_nego,
					SUM(IF (NOT ISNULL(tkontrak_penunjukan.spk_nosurat),nilai_nego,0)) AS realisasikontrak,
					SUM(IF (NOT ISNULL(tprogress_pembayaran.tgl_surat),nilai_nego,0)) AS realisasikeuangan
				FROM $dbecontract.tpengadaan
				LEFT OUTER JOIN $dbecontract.tprogress_pembayaran ON $dbecontract.tpengadaan.pgid = $dbecontract.tprogress_pembayaran.pgid
				LEFT OUTER JOIN $dbecontract.tkontrak_penunjukan ON $dbecontract.tpengadaan.pgid = $dbecontract.tkontrak_penunjukan.pgid
				WHERE $dbecontract.tpengadaan.ta = YEAR(NOW())";
		$rspl_select 			= DB::select($sql);
		$rspl 					= json_decode(json_encode($rspl_select), true);

		$sql = "SELECT count(*) AS jumlah FROM $dbecontract.tlelangumum WHERE tlelangumum.ta =  YEAR(NOW())";
		$rsjmllelang_select 	= DB::select($sql);
		$rsjmllelang 			= json_decode(json_encode($rsjmllelang_select), true);


		$sql = "SELECT count(*) AS jumlah FROM $dbecontract.tpengadaan WHERE tpengadaan.ta =  YEAR(NOW())";
		$rsjmlpl_select 		= DB::select($sql);
		$rsjmlpl 				= json_decode(json_encode($rsjmlpl_select), true);

		$sql = "SELECT SUM(nilai_nego) AS jumlah FROM $dbecontract.tpengadaan_hasillelang
				LEFT OUTER JOIN $dbecontract.tpengadaan ON $dbecontract.tpengadaan_hasillelang.pgid = $dbecontract.tpengadaan.pgid WHERE $dbecontract.tpengadaan.ta =  YEAR(NOW()) ";
		$rsjmlplselesai_select 	= DB::select($sql);
		$rsjmlplselesai 		= json_decode(json_encode($rsjmlplselesai_select), true);

		/* Dashboard Data ---- End --- Current Year*/

		/* Dashboard Data ---- Start --- Previous Year */
    	$sql = "SELECT SUM(anggaran) AS anggaran, SUM(nilai_nego) AS nilai_nego, SUM(IF (NOT ISNULL(tkontrak.sp_nosurat),nilai_nego,0)) AS realisasikontrak, SUM(IF (NOT ISNULL(tprogress_pembayaran.tgl_surat),nilai_nego,0)) AS realisasikeuangan FROM $dbecontract.tlelangumum
				LEFT OUTER JOIN $dbecontract.tkontrak ON $dbecontract.tlelangumum.lgid = $dbecontract.tkontrak.lgid
				LEFT OUTER JOIN $dbecontract.tprogress_pembayaran ON $dbecontract.tlelangumum.lgid = $dbecontract.tprogress_pembayaran.lgid
				WHERE ta = YEAR(NOW())-1 ";
		$rspgd_select 			= DB::select($sql);
		$rspgd_prev 			= json_decode(json_encode($rspgd_select), true);

		$sql = "SELECT SUM(tpengadaan.anggaran) AS anggaran, SUM(tpengadaan.nilai_nego) AS nilai_nego,
					SUM(IF (NOT ISNULL(tkontrak_penunjukan.spk_nosurat),nilai_nego,0)) AS realisasikontrak,
					SUM(IF (NOT ISNULL(tprogress_pembayaran.tgl_surat),nilai_nego,0)) AS realisasikeuangan
				FROM $dbecontract.tpengadaan
				LEFT OUTER JOIN $dbecontract.tprogress_pembayaran ON $dbecontract.tpengadaan.pgid = $dbecontract.tprogress_pembayaran.pgid
				LEFT OUTER JOIN $dbecontract.tkontrak_penunjukan ON $dbecontract.tpengadaan.pgid = $dbecontract.tkontrak_penunjukan.pgid
				WHERE $dbecontract.tpengadaan.ta = YEAR(NOW()) - 1 ";
		$rspl_select 			= DB::select($sql);
		$rspl_prev 				= json_decode(json_encode($rspl_select), true);

		$sql = "SELECT count(*) AS jumlah FROM $dbecontract.tlelangumum WHERE tlelangumum.ta =  YEAR(NOW()) - 1";
		$rsjmllelang_select 	= DB::select($sql);
		$rsjmllelang_prev 		= json_decode(json_encode($rsjmllelang_select), true);


		$sql = "SELECT count(*) AS jumlah FROM $dbecontract.tpengadaan WHERE tpengadaan.ta =  YEAR(NOW()) - 1 ";
		$rsjmlpl_select 		= DB::select($sql);
		$rsjmlpl_prev			= json_decode(json_encode($rsjmlpl_select), true);

		$sql = "SELECT SUM(nilai_nego) AS jumlah FROM $dbecontract.tpengadaan_hasillelang
				LEFT OUTER JOIN $dbecontract.tpengadaan ON $dbecontract.tpengadaan_hasillelang.pgid = $dbecontract.tpengadaan.pgid WHERE $dbecontract.tpengadaan.ta =  YEAR(NOW()) - 1 ";
		$rsjmlplselesai_select 	= DB::select($sql);
		$rsjmlplselesai_prev 	= json_decode(json_encode($rsjmlplselesai_select), true);

		/* Dashboard Data ---- End --- Previous Year */

		/* Link ---- Start */
		$birms_app[0] = array(	'Name' => "e-Musrenbang",
                      			'Link' => "http://bappeda.bandung.go.id/musrenbang",
                      			'Title' => "e-City Planning [e-Musrenbang]",
								'Icon' => "fa-building",
							  	'Iconimg' => "0.png",
								'Desc' => "Musyawarah Rencana Pembangunan melalui e-musrenbang Online",
								'Active' => 0,
								'Sub' => 0
	                    );
		$birms_app[1] = array(	'Name' => "e-Budgeting",
                      			'Link' => url('ebudgeting'),
                      			'Title' => "ebudgeting [SIMDA]",
								'Icon' => "fa-money",
							  	'Iconimg' => "1.png",
								'Desc' => "e-budgeting melalui SIMDA",
								'Active' => 0,
								'Sub' => 0
	                    );
		$birms_app[2] = array(	'Name' => "e-RUP [SIRUP]",
                      			'Link' => "https://sirup.lkpp.go.id/sirup/rekapKldi/D99",
                      			'Title' => "e-RUP [SiRUP]",
								'Icon' => "fa-history",
							  	'Iconimg' => "2.png",
								'Desc' => "Rencana Umum Pengadaan",
								'Active' => 0,
								'Sub' => 0
	                    );
		$birms_app[3] = array(	'Name' => "e-Project",
                      			'Link' => url('eproject'),
                      			'Title' => "e-Project Planning",
								'Icon' => "fa-calendar",
							  	'Iconimg' => "3.png",
								'Desc' => "Perencanaan Pekerjaan",
								'Active' => 0,
								'Sub' => 0
	                    );
		/*$birms_app[4] = array(	'Name' => "e-Pengadaan",
                      			'Link' => "",
                      			'Title' => "e-Pengadaan",
								'Icon' => "fa-balance-scale",
							  	'Iconimg' => "4.png",
								'Desc' => "Elektronik Pengadaan Barang / Jasa Secara Elektronik",
								'Active' => 0,
								'Sub' => array(
											array(	'Name' => "e-BLP",
					                      			'Link' => url('eulp'),
					                      			'Title' => "e-ULP",
													'Icon' => "fa-calendar",
												  	'Iconimg' => "11.png",
													'Desc' => "Pengajuan Lelang Umum melalui ULP",
													'Active' => 0
						                    ),
						                    array(	'Name' => "e-Proc [LPSE]",
					                      			'Link' => "http://lpse.bandung.go.id",
					                      			'Title' => "e-Procurement [LPSE]",
													'Icon' => "fa-balance-scale",
												  	'Iconimg' => "4.png",
													'Desc' => "Pengadaan Barang/Jasa melalui Lelang Umum",
													'Active' => 0
						                    ),
						                    array(	'Name' => "e-Kontrak",
					                      			'Link' => url('econtract'),
					                      			'Title' => "e-Kontrak",
													'Icon' => "fa-file-text-o",
												  	'Iconimg' => "5.png",
													'Desc' => "Pengadaan Barang/Jasa melalui Pengadaan/Penunjukan Langsung dan Manajemen Kontrak",
													'Active' => 0
						                    ),
						                    array(	'Name' => "e-Swakelola",
					                      			'Link' => url('eswakelola'),
					                      			'Title' => "e-Swakelola",
													'Icon' => "fa-users",
												  	'Iconimg' => "6.png",
													'Desc' => "Pengadaan Melalui Swakelola",
													'Active' => 0
						                    )
										)

	                    );*/

		$birms_app[4] = array(	'Name' => "e-BLP",
                      			'Link' => url('eulp'),
                      			'Title' => "e-ULP",
								'Icon' => "fa-calendar",
							  	'Iconimg' => "11.png",
								'Desc' => "Pengajuan Lelang Umum melalui ULP",
								'Active' => 0,
								'Sub' => 0
	                    );

		$birms_app[5] = array(	'Name' => "e-Proc [LPSE]",
                      			'Link' => "http://lpse.bandung.go.id",
                      			'Title' => "e-Procurement [LPSE]",
								'Icon' => "fa-balance-scale",
							  	'Iconimg' => "4.png",
								'Desc' => "Pengadaan Barang/Jasa melalui Lelang Umum",
								'Active' => 0,
								'Sub' => 0
						);
		$birms_app[6] = array(	'Name' => "e-Kontrak",
                      			'Link' => url('econtract'),
                      			'Title' => "e-Kontrak",
								'Icon' => "fa-file-text-o",
							  	'Iconimg' => "5.png",
								'Desc' => "Pengadaan Barang/Jasa melalui Pengadaan/Penunjukan Langsung dan Manajemen Kontrak",
								'Active' => 0,
								'Sub' => 0
						);
		$birms_app[7] = array(	'Name' => "e-Swakelola",
                      			'Link' => url('eswakelola'),
                      			'Title' => "e-Swakelola",
								'Icon' => "fa-users",
							  	'Iconimg' => "6.png",
								'Desc' => "Pengadaan Melalui Swakelola",
								'Active' => 0,
								'Sub' => 0
						);

		$birms_app[8] = array(	'Name' => "e-Progress",
                      			'Link' => url('eprogress'),
                      			'Title' => "e-Progress",
								'Icon' => "fa-tasks",
							  	'Iconimg' => "7.png",
								'Desc' => "Progress Pengadaan Barang/Jasa",
								'Active' => 0,
								'Sub' => 0
	                    );
		$birms_app[9] = array(	'Name' => "e-Performance",
                      			'Link' => url('eperformance'),
                      			'Title' => "e-Performance",
								'Icon' => "fa-bar-chart",
							  	'Iconimg' => "8.png",
								'Desc' => "Performance Pengadaan Barang/Jasa",
								'Active' => 0,
								'Sub' => 0
	                    );
		$birms_app[10] = array(	'Name' => "e-Asset",
                      			'Link' => url('easset'),
                      			'Title' => "e-Asset",
								'Icon' => "fa-bank",
							  	'Iconimg' => "9.png",
								'Desc' => "Asset melalui Pengadaan Barang/Jasa",
								'Active' => 0,
								'Sub' => 0
	                    );
		/* Link ---- End */

		/* Chart ---- Start */
		$sql = "SELECT * FROM $dbecontract.vlelang_bypaket";
		$rspaketlelang_select = DB::select($sql);
		$rspaketlelang 		  = json_decode(json_encode($rspaketlelang_select), true);

		$sql = "SELECT * FROM $dbecontract.vpl_bypaket";
		$rspaketpl_select = DB::select($sql);
		$rspaketpl 		  = json_decode(json_encode($rspaketpl_select), true);

		/* Chart ---- End */

		/* Search Reference ---- Start */
		$sql = "SELECT skpdID, unitID, satker, nama, singkatan FROM $dbprime.tbl_skpd WHERE isactive = 1 AND isparent = 1 ORDER BY unitID";
		$rsskpd = DB::select($sql);
		/* Search Reference ---- End */

		$total_nilai_pengadaan 		= $rspgd[0]['nilai_nego'] + $rspl[0]['nilai_nego'];
		$total_paket_lelang 		= number_format($rsjmllelang[0]['jumlah'],0,',','.');
		$total_paket_pl 			= number_format($rsjmlpl[0]['jumlah'],0,',','.');
		$total_nilai_pengumuman_pl 	= $rsjmlplselesai[0]['jumlah'];

		$total_prev_nilai_pengadaan 	= $rspgd_prev[0]['nilai_nego'] + $rspl_prev[0]['nilai_nego'];
		$total_prev_paket_lelang 		= number_format($rsjmllelang_prev[0]['jumlah'],0,',','.');
		$total_prev_paket_pl 			= number_format($rsjmlpl_prev[0]['jumlah'],0,',','.');
		$total_prev_nilai_pengumuman_pl = $rsjmlplselesai_prev[0]['jumlah'];

		$data							= [];

		$data['ref_skpd']				= $rsskpd;

    	$data['total_nilai_pengadaan'] 	= $total_nilai_pengadaan;
		$data['total_paket_lelang'] 	= $total_paket_lelang;
		$data['total_paket_pl'] 		= $total_paket_pl;
		$data['total_nilai_pengumuman_pl'] = $total_nilai_pengumuman_pl;

		$data['total_prev_nilai_pengadaan'] 	= $total_prev_nilai_pengadaan;
		$data['total_prev_paket_lelang'] 	= $total_prev_paket_lelang;
		$data['total_prev_paket_pl'] 		= $total_prev_paket_pl;
		$data['total_prev_nilai_pengumuman_pl'] = $total_prev_nilai_pengumuman_pl;

		$data['article']				= $rspost;
		$data['app']					= $birms_app;

		$data['paket_lelang']			= $rspaketlelang;
		$data['paket_pl']				= $rspaketpl;

    	return View::make("frontend.home")->with($data);
    }

	public function arrayPaginator($array, $request)
	{
	    $page = Input::get('page', 1);
	    $perPage = 10;
	    $offset = ($page * $perPage) - $perPage;

	    return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
	        ['path' => $request->url(), 'query' => $request->query()]);
	}

    function post($id)
    {
    	$dbprime = env("DB_PRIME");
    	/* Article ---- Start */
    	$sql = 	"SELECT tbl_post.pst_id,
					UPPER(tbl_post.title) AS title,
					tbl_post.summary,
					tbl_post.content,
					tbl_post.source,
					tbl_post.tags,
					tbl_post.poststatus,
					tbl_post.hits,
					tbl_postcontent.position,
					tbl_content.shortname,
					tbl_content.`name`,
					tbl_content.filename,
					tbl_post.created
				FROM $dbprime.tbl_post
					LEFT OUTER JOIN $dbprime.tbl_postcontent ON $dbprime.tbl_post.pst_id = $dbprime.tbl_postcontent.pst_id
					LEFT OUTER JOIN $dbprime.tbl_content ON $dbprime.tbl_postcontent.con_id = $dbprime.tbl_content.con_id
				WHERE tbl_post.pst_id = ".$id." ";
		$rspost = DB::select($sql);
    	/* Article ---- Finish */

    	$data			 = [];
		$data['article'] = $rspost;
    	return View::make("frontend.post")->with($data);
    }

    function search1(Request $request)
    {
    	/*$data = [];
    	$filename = "http://localhost/oc-bandung/newbirms_old/public/api/search?q=test&ta=2017";

    	try
		{
		    $contents = File::get($filename);
		}
		catch (Illuminate\Filesystem\FileNotFoundException $exception)
		{
		    die("File tidak ada");
		}

		$data = json_decode($json, true);

    	return View::make("frontend.search")->with($data);
    	//view('your-view')->with('leads', json_decode($leads, true));*/

    }

    function search(Request $request)
    {
    	$dbplanning = env("DB_PLANNING");
    	$dbecontract = env("DB_CONTRACT");
    	$dbprime = env("DB_PRIME");

    	$data			 = [];

		/* Search Reference ---- Start */
		$sql = "SELECT skpdID, unitID, satker, nama, singkatan FROM $dbprime.tbl_skpd WHERE isactive = 1 AND isparent = 1 ORDER BY unitID";
		$rsskpd = DB::select($sql);
		/* Search Reference ---- End */

		$data['ref_skpd'] = $rsskpd;

    	if (!empty($request)) {
	    	$q 		= $request->input('q');
	    	$tahun 	= $request->input('tahun');
	    	//$skpdID = $request->input('skpdID');
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
								`tbl_pekerjaan`.laksana_end,
								`tpekerjaan`.pekerjaanstatus
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
							//echo $sql;
			    	$rspengadaan = DB::select($sql);
			    	/*$rspengadaan = DB::table($dbecontract.'.tpengadaan AS pgd')
			    						->addSelect(DB::raw('kodepekerjaan,
			    							sirupID,
			    							tbl_metode.nama AS metodepengadaan,
			    							pgd.namakegiatan,
			    							pgd.namapekerjaan,
			    							pgd.nilai_nego,
			    							pgd.skpdID,
			    							unitID,
			    							tbl_skpd.nama AS namaskpd,
			    							pgd.ta,
			    							pgd.anggaran,
			    							tsumberdana.sumberdana,
			    							pgd.klasifikasiID,
											LEFT(tklasifikasi.kode,2) AS kodeklasifikasi,
											CASE
								     			WHEN LEFT(`tklasifikasi`.kode,2) = 1 THEN "Konstruksi"
								     			WHEN LEFT(`tklasifikasi`.kode,2) = 2 THEN "Pengadaan Barang"
								     			WHEN LEFT(`tklasifikasi`.kode,2) = 3 THEN "Jasa Konsultansi"
								     			WHEN LEFT(`tklasifikasi`.kode,2) = 4 THEN "Jasa Lainnya"
								     		ELSE "N/A"
								  			END AS klasifikasi,
			    							tbl_pekerjaan.pilih_start,
											tbl_pekerjaan.pilih_end,
											tbl_pekerjaan.laksana_start,
											tbl_pekerjaan.laksana_end'))
			    						->leftJoin($dbecontract.'.tpekerjaan', 'pgd.pid', '=', 'tpekerjaan.pid')
										->leftJoin($dbplanning.'.tbl_pekerjaan', 'tpekerjaan.pekerjaanID', '=', 'tbl_pekerjaan.pekerjaanID')
										->leftJoin($dbplanning.'.tbl_metode', 'tpekerjaan.metodeID', '=', 'tbl_metode.metodeID')
										->leftJoin($dbprime.'.tbl_skpd', 'pgd.skpdID', '=', 'tbl_skpd.skpdID')
										->leftJoin($dbecontract.'.tsumberdana', 'pgd.sumberdanaid', '=', 'tsumberdana.sumberdanaid')
										->leftJoin($dbecontract.'.tklasifikasi', 'pgd.klasifikasiID', '=', 'tklasifikasi.klasifikasiID')
			    						->where([
												    ['pgd.ta', 'LIKE', DB::raw('"%'.$tahun.'%"')]
												]
			    							)
			    						->get();*/
			}
	    	$data['pengadaan'] 	 = $rspengadaan;
	    	//$data['pengadaan'] = $rspengadaan->toArray();
	    	$data['totalsearch'] = count($rspengadaan);
    	} else {
    		$data['message'] = 'Silahkan isi kata yang ingin dicari terlebih dahulu';
    	}
    	return View::make("frontend.search")->with($data);
    }
}
