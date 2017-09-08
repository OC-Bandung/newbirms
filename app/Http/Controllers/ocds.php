<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sirup;
use Illuminate\Support\Facades\DB;

class ApiBIRMS extends Controller
{
    public function sirupAll($year)
	{
		$results = Sirup::where("tahun", $year)->limit(5)->get(); 
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

	/*	$sql = 'SELECT
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
				LEFT OUTER JOIN 2016_birms_prime.tbl_user ON tr_sk_user.usrID = 2016_birms_prime.tbl_user.usrID
				LEFT OUTER JOIN 2016_birms_prime.tbl_skpd ON tbl_sk.skpdID = 2016_birms_prime.tbl_skpd.skpdID

				LIMIT 10';
	*/			
		$sql = 'SELECT
	tpengadaan.pgid, tpengadaan.pid, tpengadaan.kode AS id, 
        tbl_instansi.nama AS buyer_name,
        tbl_skpd.nama AS buyer_contactpoint_name, 
        tbl_sirup.nama AS planning_rationale,
        tpengadaan.kode AS planning_budget_id,
        sumberdana AS planning_budget_description,
        tpengadaan.ta AS planning_budget_year,
        tpengadaan.anggaran AS planning_budget_amount_amount,
    
        tpengadaan.pid AS tender_id,
        tpengadaan.namapekerjaan AS tender_title,
        tpengadaan.namakegiatan AS tender_description,
        tpengadaan.pekerjaanstatus AS tender_status,
        tpengadaan.hps AS tender_value_amount,
        tanggal_awal_pengadaan AS tender_tenderPeriod_startDate,
        tanggal_akhir_pengadaan AS tender_tenderPeriod_endDate,
		\'\' AS tender_enquiryPeriod,
		\'\' AS tender_enquiryPeriod_startDate,
		\'\' AS tender_enquiryPeriod_endDate,
		\'\' AS tender_eligibilityCriteria,
		\'\' AS tender_awardPeriod,
		\'\' AS tender_awardPeriod_startDate,
		\'\' AS tender_awardPeriod_endDate,
		\'\' AS tender_items,
		(case left(tklasifikasi.kode,2) when \'01\' then \'Konstruksi\' when \'02\' then \'Pengadaan Barang\' when \'03\' then \'Jasa Konsultansi\' when \'04\' then \'Jasa Lainnya\' else \'Pengadaan Barang\' end) AS tender_items_description,
		\'\' AS tender_numberOfTenderers,
		\'\' AS tender_tenderers,
		\'\' AS tender_tenderers_identifier_legalName,
		\'\' AS tender_tenderers_additionalIdentifiers_id,
		\'\' AS tender_procuringEntity,
		tbl_instansi.nama AS tender_procuringEntity_identifier_legalName,
		tbl_skpd.nama AS tender_procuringEntity_contactPoint_name,
		\'\' AS tender_documents,
		\'\' AS tender_milestones,
		\'\' AS tender_milestones_id,
		\'\' AS tender_milestones_title,
		tbl_sirup.tanggal_akhir_pengadaan AS tender_milestones_dueDate,
		\'\' AS tender_milestones_dateModified,
		tpengadaan.pid AS awards_id,
		tpengadaan.namapekerjaan AS awards_title,
		tpengadaan_pemenang.tgl_surat AS awards_date,
		tpengadaan_pemenang.nilai AS awards_value_amount,
		tpengadaan_pemenang.tgl_surat AS awards_contractPeriod,
		tkontrak_penunjukan.spk_tgl_surat AS awards_contractPeriod_startDate,
		tkontrak_penunjukan.spk_tgl_slskontrak AS awards_contractPeriod_endDate,
		tpengadaan_pemenang.perusahaannama AS awards_suppliers,
		tpengadaan_pemenang.perusahaannpwp AS awards_suppliers_identifier,
		tpengadaan_pemenang.perusahaannama AS awards_suppliers_identifier_legalName,
		tpengadaan_pemenang.perusahaannama AS awards_suppliers_name,
		tpengadaan_pemenang.perusahaanalamat AS awards_suppliers_address,

		(case left(tklasifikasi.kode,2) when \'01\' then \'Konstruksi\' when \'02\' then \'Pengadaan Barang\' when \'03\' then \'Jasa Konsultansi\' when \'04\' then \'Jasa Lainnya\' else \'Pengadaan Barang\' end) AS awards_items_description,
		\'\' AS contracts,
		tpengadaan.namapekerjaan AS contracts_title,
		\'\' AS contracts_period,
		tpengadaan.nilai_nego AS contracts_value,
		\'\' AS contracts_amendment,
		\'\' AS contracts_implementation,
		tbl_skpd.nama AS contracts_implementation_transactions_receiverOrganization,
		tbl_skpd.unitID AS contracts_imp_trans_recOrg_id,
		tbl_skpd.nama AS contracts_imp_trans_recOrg_legalName,
		\'\' AS contracts_implementation_milestones,
		\'\' AS contracts_implementation_milestones_description
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
WHERE tpengadaan.ta = 2016 AND tbl_pekerjaan.sirupID <> 0 AND NOT ISNULL(tbl_pekerjaan.sirupID) LIMIT 1';

		$results = DB::select($sql);
    	return response()->json($results)->header('Access-Control-Allow-Origin', '*');
	  
	}
}
