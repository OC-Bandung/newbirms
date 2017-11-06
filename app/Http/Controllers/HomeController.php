<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

    	/* Dashboard Data ---- Start */
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

		/* Dashboard Data ---- Finish */

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
		/* Link ---- Finish */

		$total_nilai_pengadaan 		= $rspgd[0]['nilai_nego'] + $rspl[0]['nilai_nego'];
		$total_paket_lelang 		= number_format($rsjmllelang[0]['jumlah'],0,',','.');
		$total_paket_pl 			= number_format($rsjmlpl[0]['jumlah'],0,',','.');
		$total_nilai_pengumuman_pl 	= $rsjmlplselesai[0]['jumlah'];

		$data							= [];
    	$data['total_nilai_pengadaan'] 	= $total_nilai_pengadaan; 
		$data['total_paket_lelang'] 	= $total_paket_lelang;
		$data['total_paket_pl'] 		= $total_paket_pl;
		$data['total_nilai_pengumuman_pl'] = $total_nilai_pengumuman_pl;
		$data['article']				= $rspost;
		$data['app']					= $birms_app;
		
    	return View::make("frontend.home")->with($data);
    }
}
