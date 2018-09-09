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
		$dbplanning  = env('DB_PLANNING');
    	$dbecontract = env("DB_CONTRACT");
    	$dbprime 	 = env("DB_PRIME");

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
		/* get all sirup */
		$sql = "SELECT COUNT(*) AS jumlah, SUM(pagu) AS pagu FROM ".$dbplanning.".tbl_sirup WHERE tahun = YEAR(NOW())";
		$rssirup_select 		= DB::select($sql);
		$rssirup 					= json_decode(json_encode($rssirup_select), true);

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

		$sql = "SELECT count(*) AS jumlah, SUM(nilai_nego) AS kontrak FROM $dbecontract.tlelangumum WHERE tlelangumum.ta =  YEAR(NOW())";
		$rsjmllelang_select 	= DB::select($sql);
		$rsjmllelang 			= json_decode(json_encode($rsjmllelang_select), true);

		$sql = "SELECT count(*) AS jumlah, SUM(nilai_nego) AS kontrak FROM $dbecontract.tpengadaan WHERE tpengadaan.ta =  YEAR(NOW()) AND pekerjaanstatus = 7";
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

		$sql = "SELECT count(*) AS jumlah, SUM(nilai_nego) AS kontrak FROM $dbecontract.tlelangumum WHERE tlelangumum.ta =  YEAR(NOW()) - 1";
		$rsjmllelang_select 	= DB::select($sql);
		$rsjmllelang_prev 		= json_decode(json_encode($rsjmllelang_select), true);

		$sql = "SELECT count(*) AS jumlah, SUM(nilai_nego) AS kontrak FROM $dbecontract.tpengadaan WHERE tpengadaan.ta =  YEAR(NOW()) - 1 ";
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

		$total_prev_nilai_pengadaan 	= $rspgd_prev[0]['nilai_nego'] + $rspl_prev[0]['nilai_nego'];
		$total_prev_paket_tender		= number_format($rsjmllelang_prev[0]['jumlah'],0,',','.');
		$total_prev_nilai_tender		= number_format($rsjmllelang_prev[0]['kontrak'],0,',','.');
		$total_prev_paket_nontender 	= number_format($rsjmlpl_prev[0]['jumlah'],0,',','.');
		$total_prev_nilai_nontender 	= number_format($rsjmlpl_prev[0]['kontrak'],0,',','.');
		$total_prev_nilai_pengumuman_pl = $rsjmlplselesai_prev[0]['jumlah'];

		$data							= [];

		$data['ref_skpd']				= $rsskpd;
		
		$data['total_paket_sirup']			= $rssirup[0]['jumlah'];
		$data['total_nilai_sirup']			= $rssirup[0]['pagu'];

		$data['total_paket_tender'] 		= number_format($rsjmllelang[0]['jumlah'],0,',','.');
		$data['total_nilai_tender'] 		= $rsjmllelang[0]['kontrak'];
		$data['total_paket_nontender'] 		= number_format($rsjmlpl[0]['jumlah'],0,',','.');
		$data['total_nilai_nontender'] 		= $rsjmlpl[0]['kontrak'];

		$data['total_paket_kontrak'] 		= $rsjmllelang[0]['jumlah'] + $rsjmlpl[0]['jumlah'];
		$data['total_nilai_kontrak'] 		= $rsjmllelang[0]['kontrak'] + $rsjmlpl[0]['kontrak'];

		$data['total_nilai_pengumuman_pl'] = $rsjmlplselesai[0]['jumlah'];

		$data['total_prev_nilai_pengadaan'] 	= $total_prev_nilai_pengadaan;
		
		$data['total_prev_paket_tender'] 		= $total_prev_paket_tender;
		$data['total_prev_nilai_tender'] 		= $total_prev_nilai_tender;
		$data['total_prev_paket_nontender'] 	= $total_prev_paket_nontender;
		$data['total_prev_nilai_nontender'] 	= $total_prev_nilai_nontender;
		
		$data['total_prev_nilai_pengumuman_pl'] = $total_prev_nilai_pengumuman_pl;

		$data['article']				= $rspost;
		$data['app']					= $birms_app;

		$data['paket_lelang']			= $rspaketlelang;
		$data['paket_pl']				= $rspaketpl;

    	return View::make("frontend.home")->with($data);
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
	    	$jenis_pengadaanID = $request->input('jenis_pengadaanID');
	    	$tahap 	= $request->input('tahap');

	    	$min 	= $request->input('min');
	    	$max 	= $request->input('max');
	    	$startdate = $request->input('startdate');
	    	$enddate = $request->input('enddate');

			$sql = 'SELECT *
					FROM
						(
							SELECT
							CONCAT("'.env('OCID').'","s-",tahun,"-",tbl_sirup.sirupID) AS ocid,
							tlelangumum.lls_id AS lelangID,
							tbl_sirup.sirupID,
							tbl_sirup.tahun,
							tbl_sirup.nama AS namapekerjaan,
							1 AS iswork,
							IF((ISNULL(pekerjaanstatus) OR (pekerjaanstatus = 0)), "1", pekerjaanstatus) AS pekerjaanstatus,
							CASE
									WHEN (pekerjaanstatus = 4 OR pekerjaanstatus = 5) THEN 2
									WHEN pekerjaanstatus = 6 THEN 3
									WHEN pekerjaanstatus = 7 THEN 4
									ELSE 1
								END AS tahap,
							CASE
								WHEN (pekerjaanstatus = 4 OR pekerjaanstatus = 5) THEN "Aktif"
								WHEN pekerjaanstatus = 6 THEN "Gagal"
								WHEN pekerjaanstatus = 7 THEN "Selesai"
								ELSE "Perencanaan"
							END AS tahapan,
							tbl_sirup.pagu AS pagu_anggaran,
							tbl_sirup.sumber_dana_string,
							tbl_sirup.jenis_pengadaan AS jenis_pengadaanID, 
							(
							CASE
									
									WHEN tbl_sirup.jenis_pengadaan = 1 THEN
									"Pengadaan Barang" 
									WHEN tbl_sirup.jenis_pengadaan = 2 THEN
									"Pekerjaan Konstruksi" 
									WHEN tbl_sirup.jenis_pengadaan = 3 THEN
									"Jasa Konsultansi" 
									WHEN tbl_sirup.jenis_pengadaan = 4 THEN
									"Jasa Lainnya" ELSE "N/A" 
								END 
								) AS jenis_pengadaan,
								tbl_sirup.tanggal_awal_pengadaan,
								tbl_sirup.tanggal_akhir_pengadaan,
								tbl_sirup.satuan_kerja AS namaskpd,
								tlelangumum.nilai_nego 
							FROM
								'.$dbplanning.'.tbl_sirup
								LEFT JOIN '.$dbecontract.'.tlelangumum ON tbl_sirup.sirupID = tlelangumum.sirupID 
							WHERE tbl_sirup.pagu <> 0 AND tbl_sirup.metode_pengadaan IN (1,2,3,4,5,6,10,11,12)
								AND tbl_sirup.isswakelola = 0 
							
							UNION
							
							SELECT
								CONCAT( "'.env('OCID').'", "b-", tbl_pekerjaan.tahun, "-", tbl_pekerjaan.pekerjaanID  ) AS ocid,
								tpengadaan.pgid AS lelangID,
								tbl_pekerjaan.pekerjaanID AS sirupID,
								tbl_pekerjaan.tahun,
								tbl_pekerjaan.namapekerjaan,
								iswork,
								tpengadaan.pekerjaanstatus,
								CASE
									WHEN (tpengadaan.pekerjaanstatus = 4 OR tpengadaan.pekerjaanstatus = 5) THEN 2
									WHEN tpengadaan.pekerjaanstatus = 6 THEN 3
									WHEN tpengadaan.pekerjaanstatus = 7 THEN 4
									ELSE 1
								END AS tahap,
								CASE
									WHEN (tpengadaan.pekerjaanstatus = 4 OR tpengadaan.pekerjaanstatus = 5) THEN "Aktif"
									WHEN tpengadaan.pekerjaanstatus = 6 THEN "Gagal"
									WHEN tpengadaan.pekerjaanstatus = 7 THEN "Selesai"
									ELSE "Perencanaan"
								END AS tahapan,
								tbl_pekerjaan.anggaran AS pagu_anggaran,
								tbl_sumberdana.sumberdana AS sumber_dana_string,
								tbl_jenis.jenisID AS jenis_pengadaanID, 
								tbl_jenis.nama AS jenis_pengadaan,
								pilih_start AS tanggal_awal_pengadaan,
								pilih_end AS tanggal_akhir_pengadaan,
								tbl_skpd.nama AS namaskpd,
								tpengadaan.nilai_nego 
							FROM
								'.$dbplanning.'.tbl_pekerjaan
								LEFT JOIN tbl_sumberdana ON tbl_pekerjaan.sumberdanaID = tbl_sumberdana.sumberdanaID
								LEFT JOIN tbl_metode ON tbl_pekerjaan.metodeID = tbl_metode.metodeID
								LEFT JOIN tbl_jenis ON tbl_metode.jenisID = tbl_jenis.jenisID
								LEFT JOIN '.$dbprime.'.tbl_skpd ON tbl_pekerjaan.skpdID = tbl_skpd.skpdID
								LEFT JOIN '.$dbecontract.'.tpekerjaan ON tbl_pekerjaan.pekerjaanID = tpekerjaan.pekerjaanID
								LEFT JOIN '.$dbecontract.'.tpengadaan ON tpekerjaan.pid = tpengadaan.pid 
							WHERE tbl_pekerjaan.iswork = 1 
								) AS pengadaan 
						WHERE true ';

						if (!empty($q)) {
							$sql .= ' AND pengadaan.namapekerjaan LIKE \'%'.$q.'%\' ';
						}

						if (!empty($tahun)) {
							$sql .= ' AND tahun = '.$tahun.' ';
						}

						if (!empty($tahap)) {
							$sql .= ' AND pengadaan.pekerjaanstatus = '.$tahap.' ';
						}

						if (!empty($jenis_pengadaanID)) {
							$sql .= ' AND pengadaan.jenis_pengadaanID = '.$jenis_pengadaanID.' ';
						}

						if (!empty($min)) {
							$sql .= ' AND (pengadaan.pagu_anggaran >= '.$min.' OR pengadaan.nilai_nego >= '.$min.') ';
						}

						if (!empty($max)) {
							$sql .= ' AND (pengadaan.pagu_anggaran <= '.$max.' OR pengadaan.nilai_nego <= '.$max.') ';
						}
			
			//echo $sql;
			$rspengadaan = DB::select($sql);										
			$data['totalsearch'] = count($rspengadaan);
			$rspengadaan = $this->arrayPaginator($rspengadaan, $request);

			$data['pengadaan'] 	 = $rspengadaan;
	    	//$data['pengadaan'] = $rspengadaan->toArray();
    	} else {
    		$data['message'] = 'Silahkan isi kata yang ingin dicari terlebih dahulu';
    	}
    	return View::make("frontend.search")->with($data);
	}
	
	function contract()
    {
    	$data			 = [];
    	return View::make("frontend.contract")->with($data);
	}
	
	function watched()
    {
    	$data			 = [];
    	return View::make("frontend.watched")->with($data);
    }
}