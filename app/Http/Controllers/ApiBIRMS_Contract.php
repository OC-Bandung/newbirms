<?php

namespace App\Http\Controllers;

use App\Dto\CustomDtoServiceContainer;
use DateTime;
use Dto\JsonSchemaRegulator;
use Dto\ServiceContainer;
use Illuminate\Contracts\Routing\ResponseFactory;
use Dto\Dto;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use stdClass;


class OcdsRelease extends Dto
{
    /**
     * Receives a response factory from laravel and returns this object as json.
     * We do not use the response()->json here since the Dto knows how to print itself as json and converts
     * structures stored internally to json compliant (scalars as 1 index arrays).
     * @param $response
     * @return mixed
     */
    function getJsonResponse(ResponseFactory $response)
    {
        return $response->make($this->toJson(true))->header('Content-Type', 'application/json');
    }

    /**
     * We override the getDefaultRegulator to provide a different service provider
     * @param mixed $regulator
     * @return JsonSchemaRegulator|\Dto\RegulatorInterface|mixed
     */
    protected function getDefaultRegulator($regulator)
    {
        if (is_null($regulator)) {
            return new JsonSchemaRegulator(new CustomDtoServiceContainer(), get_called_class());
        }
        return $regulator;
    }
}


class ApiBIRMS_contract extends Controller
{


    /**
     * Gets the ocds schema loaded from local storage.
     * Ensures additional properties are set to false, to fail if unknown properties are used
     * @return schema
     */
    function getOcdsSchema()
    {
        $schema = json_decode(Storage::disk('public')->get('release-schema.json'), true);
        //ensure no extra properties allowed in root entity
        $schema['additionalProperties'] = false;
        //ensure no extra properties allowed in any definitions within root entity
        foreach ($schema['definitions'] as &$definition)
            $definition['additionalProperties'] = false;
        return $schema;
    }

    /**
     * Gets the planning section of Release
     * @param $ocid
     */
    function getPlanning($results)
    {
        $planning = new stdClass();
        $planning->budget = $this->getBudget($results);

        return $planning;
    }

    function getContactPoint($row)
    {
        $cp = new stdClass();
        $cp->email = $row->email;
        $cp->telephone = $row->telepon;
        return $cp;
    }

    function getAddress($row)
    {
        $a = new stdClass();
        $a->streetAddress = $row->alamat;
        return $a;
    }

    function getAddressPerusahaan($row)
    {
        $a = new stdClass();
        $a->streetAddress = $row->alamatperusahaan;
        return $a;
    }

    function getOrganizationByName($year, $name, $role = null)
    {
        $name=preg_replace('/\s+/', ' ', $name);
        if ($year <= 2016) {
            $db = env('DB_PRIME_PREV');
        } else {
            $db = env('DB_PRIME');
        }
        $dbeproc = env('DB_EPROC');

        if ($role == "supplier") { 
            $sql = "SELECT * FROM " . $dbeproc . ".tperusahaan WHERE UCASE(namaperusahaan) = UCASE('".$name."') ";
        } else {
            $sql = "SELECT * FROM " . $db . ".tbl_skpd WHERE UCASE(nama) = UCASE('" . $name . "')";
        }
        $results = DB::select($sql);
        
        if (sizeof($results) == 0) {
            abort(404, 'No organization found by name ' . $name);
        } else {
            $row = $results[0];

            $org = new stdClass();
            if ($role == "supplier") { 
                $org->id = $row->npwp;
                $org->name = $row->namaperusahaan;
                $org->address = $this->getAddressPerusahaan($row);
                $org->contactPoint = $this->getContactPoint($row); 
                
                $id = new stdClass();
                $id->id = $row->npwp;
                $id->legalName = $row->namaperusahaan;
                $org->identifier = $id;
            } else {
                $org->id = $row->unitID;
                $org->name = $row->nama;
                $org->address = $this->getAddress($row);
                $org->contactPoint = $this->getContactPoint($row);

                $id = new stdClass();
                $id->id = $row->unitID;
                $id->legalName = $row->nama;
                $org->identifier = $id;
            }
            return $org;
        }
    }

    function getOrganizationReferenceByName($year, $name, $role, &$parties, $orgObj = null)
    {
        //first check if organization is within parties array
        foreach ($parties as &$o) {
            if (strcasecmp($o->name, $name) == 0) {
                global $org;
                $org = $o;
            }
        }

        //if not found, read new organization from org table
        if (!isset($org)) {
            $org = $this->getOrganizationByName($year, $name, $role);
            $org->roles = [$role];
            array_push($parties, $org);
        } else {
            //if found
            //check if the role currently used was already added, if not add it
            if (!in_array($role, $org->roles)) {
                array_push($org->roles, $role);
            }
        }

        return $this->getOrganizationReferenceFromOrg($org);
    }

    function getMainProcurementCategory($results)
    {
        if ($results->jenis_belanja == 1)
            return null;
        if ($results->jenis_belanja == 2) {
            return "services";
        }
        abort(404, 'No main procurement category can be mapped for  code ' . $results->jenis_belanja);
    }

    function getAmount($amount)
    {
        $a = new stdClass();
        $a->amount = (double)$amount;
        $a->currency = env('CURRENCY');
        return $a;
    }

    function getUnit($unit)
    {
        $a = new stdClass();
        $a->unit = $unit;
        return $a;
    }

    function getBudget($results)
    {
        $budget = new stdClass();
        $budget->amount = $this->getAmount($results->pagu);
        $budget->description = $results->sumber_dana_string;
        $budget->project = $results->nama;
        return $budget;
    }

    function getOrganizationReferenceFromOrg($org)
    {
        $reference = new stdClass();
        if(isset($org->id)) {
            $reference->id = $org->id;
        }
        $reference->name = $org->name;
        return $reference;
    }

    function getPeriod($startDate, $endDate)
    {
        $period = new stdClass();
        $period->startDate = $this->getOcdsDateFromString($startDate);
        $period->endDate = $this->getOcdsDateFromString($endDate);
        return $period;
    }

    function getNonLelangID($sirupID)
    {
        $db = env('DB_CONTRACT');
        $sql = "SELECT * FROM " . $db . ".tpekerjaan WHERE pekerjaanID = " . $sirupID . " ";
        $results = DB::select($sql);
        if (sizeof($results) == 0) {
            //abort(404, 'No procurement found by sirupID ' . $sirupID);
            $lelangID = 0;
        } else {
            $row = $results[0];
            $pid = (int)$row->pid;
        }
        return $pid;
    }

    function getLelangID($sirupID)
    {
        $db = env('DB_CONTRACT');
        $sql = "select * from " . $db . ".tlelangumum where sirupID = " . $sirupID . " ";
        $results = DB::select($sql);
        if (sizeof($results) == 0) {
            //abort(404, 'No procurement found by sirupID ' . $sirupID);
            $lelangID = 0;
        } else {
            $row = $results[0];
            $lelangID = (int)$row->lls_id;
        }
        return $lelangID;
    }
   
    function getNumberOfTenderers($sirupID)
    {
        $db = env('DB_CONTRACT');
        $sql = "select * from " . $db . ".tlelangumum where sirupID = " . $sirupID . " ";
        $results = DB::select($sql);
        if (sizeof($results) == 0) {
            //abort(404, 'No procurement found by sirupID ' . $sirupID);
            $bidder = 0;
        } else {
            $row = $results[0];
            $bidder = (int)$row->jumlah_peserta;
        }
        return $bidder;
    }

    function getTenderMilestones($sirupID)
    {
        $db = env('DB_CONTRACT');
        $milestoneDateFormat = 'Y-m-d H:i:s';
        $sql = "select * from " . $db . ".tlelangumum where sirupID = " . $sirupID . " ";
        $results = DB::select($sql);
        if (sizeof($results) == 0) {
            //abort(404, 'No procurement found by sirupID ' . $sirupID);
            $milestones = [];
        } else {
            $row = $results[0];
            $lls_id = $row->lls_id;

            $db = env('DB_CONTRACT');
            $sql = "SELECT dtj_id, thp_id, lpse_jadwal.lls_id, lpse_jadwal.auditupdate, dtj_tglawal, dtj_tglakhir, dtj_keterangan, akt_jenis, akt_urut, akt_status, lpse_aktivitas.akt_id FROM " . $db . ".lpse_jadwal
            LEFT JOIN " . $db . ".lpse_aktivitas ON lpse_jadwal.akt_id = lpse_aktivitas.akt_id
            WHERE lls_id = " . $lls_id . " ORDER BY akt_urut";
            $results = DB::select($sql);

            if (sizeof($results) == 0) {
                abort(404, 'No milestone found by lelang ID ' . $lls_id);
            }

            $milestones = [];
            foreach ($results as $row) {
                array_push($milestones, $this->getTenderMilestone($row));
            }
        }
        return $milestones;
    }

    function getNonTenderMilestones($pID)
    {
        $db = env('DB_CONTRACT');
        $milestoneDateFormat = 'Y-m-d H:i:s';
        $sql = "SELECT tahapID, nama, tanggal_mulai, tanggal_selesai FROM " . $db . ".tpekerjaan_jadwal
                LEFT JOIN " . $db . ".tmaster_tahap ON tpekerjaan_jadwal.tahapID = tmaster_tahap.ID
                WHERE pid = " . $pID . " ";
        $results = DB::select($sql);
        if (sizeof($results) == 0) {
            //abort(404, 'No procurement found by sirupID ' . $sirupID);
            $milestones = [];
        } else {
            $milestones = [];
            foreach ($results as $row) {
                array_push($milestones, $this->getNonTenderMilestone($row));
            }
        }
        return $milestones;
    }

    function getNonCompetitiveAward($year, $row, &$parties)
    {
        $a = new stdClass();
        $a->id = $row->id;
        $a->title = $row->namapekerjaan;
        $a->date = $this->getOcdsDateFromString($row->pilih_start);

        $a->status = "active";
        $a->value = $this->getAmount($row->nilai_nego);

        $supl       = new stdClass();
        $supl->name = $row->perusahaannama;
        
        $orgId      = new stdClass();
        $orgId->legalName=$row->perusahaannama;
        $supl->identifier=$orgId;

        $addr=new stdClass();
        $addr->streetAddress=$row->perusahaanalamat;
        $supl->address=$addr;

        $a->suppliers = [$this->getOrganizationReferenceByName($year, $row->perusahaannama, "supplier", $parties, $orgId)];
        return $a;
    }

    function getCompetitiveAward($year, $row, &$parties)
    {
        $a = new stdClass();
        $a->id = $row->lgid;
        $a->title = $row->namapekerjaan;
        $a->date = $this->getOcdsDateFromString($row->tanggalpengumuman);
        
        if ($row->nilai_nego != 0) {
            $a->status = "active";
            $a->value = $this->getAmount($row->nilai_nego);

            $supl       = new stdClass();
            $supl->name = $row->pemenang;
            
            $orgId      = new stdClass();
            $orgId->legalName=$row->pemenang;
            $supl->identifier=$orgId;

            $addr=new stdClass();
            $addr->streetAddress=$row->pemenangalamat;
            $supl->address=$addr;

            $a->suppliers = [$this->getOrganizationReferenceByName($year, $row->pemenang, "supplier", $parties, $orgId)];
        } else {
            $a->status = "pending";
        }
        return $a;
    }


    function getNonCompetitiveAwards($year, $pekerjaanID, &$parties) {
        //TODO: please write query to get to noncompetitive awards here
        $db = env('DB_PLANNING');
        $sql = "SELECT
                    CONCAT(
                        REPLACE(tpekerjaan.tanggalrencana,'-',''),
                        '.' ,
                        tpekerjaan.pid ,
                        '.' ,
                        tpekerjaan.saltid
                    ) AS id ,
                    tbl_pekerjaan.namapekerjaan ,
                    pilih_start ,
                    nilai_nego ,
                    perusahaanid ,
                    perusahaannama ,
                    perusahaanalamat ,
                    perusahaannpwp
                FROM
                    tbl_pekerjaan
                LEFT JOIN birms_econtract.tpekerjaan ON tbl_pekerjaan.pekerjaanID = tpekerjaan.pekerjaanID
                LEFT JOIN birms_econtract.tpengadaan ON tpekerjaan.pid = tpengadaan.pid
                LEFT JOIN birms_econtract.tpengadaan_pemenang ON tpengadaan.pgid = tpengadaan_pemenang.pgid
                WHERE
                    tbl_pekerjaan.pekerjaanID = ". $pekerjaanID . " ";
        $results = DB::select($sql);

        $awards = [];
        foreach ($results as $row) {
            array_push($awards, $this->getNonCompetitiveAward($year, $row, $parties));
        }

        return $awards;
    }

    function getCompetitiveAwards($year, $sirupID, &$parties)
    {
        $db = env('DB_CONTRACT');
        $sql = "select * from " . $db . ".tlelangumum where sirupID = " . $sirupID . " ";
        $results = DB::select($sql);

        $awards = [];
        foreach ($results as $row) {
            array_push($awards, $this->getCompetitiveAward($year, $row, $parties));
        }

        return $awards;
    }

    function getMilestoneStatus($dueDate, $dateMet)
    {
        $now = date('Y-m-d H:i:s');
        $milestoneStatus = new stdClass();
        if ($dateMet > $now) {
            $milestonestatusCode = "notMet";
        } else if ($dateMet <= $now) {
            $milestonestatusCode = "met";
        }

        if ($dueDate <= $now) {
            $milestonestatusCode = "scheduled";
        }
        $milestoneStatus->Status = $milestonestatusCode;

        return $milestonestatusCode;
    }

    function getNonTenderMilestone($row)
    {
        $milestoneDateFormat = 'Y-m-d H:i:s';
        $milestone = new stdClass();

        $milestone->id = $row->tahapID;
        $milestone->title = $row->nama;
        //$milestone->description = $row->dtj_keterangan;
        $milestone->dueDate = $this->getOcdsDateFromString($row->tanggal_selesai, $milestoneDateFormat);
        $milestone->dateMet = $this->getOcdsDateFromString($row->tanggal_mulai, $milestoneDateFormat);
        //$milestone->dateModified = $this->getOcdsDateFromString($row->auditupdate, $milestoneDateFormat);
        $milestone->status = $this->getMilestoneStatus($row->tanggal_selesai, $row->tanggal_mulai);
        //$milestone->status = $row->akt_status; //TODO: titan we need a mapping here between akt_status and milestone
        //status http://standard.open-contracting.org/1.1/en/schema/codelists/#milestone-status
        return $milestone;
    }

    function getTenderMilestone($row)
    {
        $milestoneDateFormat = 'Y-m-d H:i:s';
        $milestone = new stdClass();
        $milestone->id = $row->akt_id;
        $milestone->title = $row->akt_jenis;
        $milestone->description = $row->dtj_keterangan;
        $milestone->dueDate = $this->getOcdsDateFromString($row->dtj_tglakhir, $milestoneDateFormat);
        $milestone->dateMet = $this->getOcdsDateFromString($row->dtj_tglawal, $milestoneDateFormat);
        //$milestone->dateModified = $this->getOcdsDateFromString($row->auditupdate, $milestoneDateFormat);
        $milestone->status = $this->getMilestoneStatus($row->dtj_tglakhir, $row->dtj_tglawal);
        //$milestone->status = $row->akt_status; //TODO: titan we need a mapping here between akt_status and milestone
        //status http://standard.open-contracting.org/1.1/en/schema/codelists/#milestone-status
        return $milestone;
    }

    function getTender($year, $results, &$parties)
    {
        $tender = new stdClass();
        $tender->id = $this->getLelangID($results->sirupID);
        $tender->procurementMethod = $this->getProcurementMethod($results->metode_pengadaan);
        $tender->tenderPeriod = $this->getPeriod($results->tanggal_awal_pengadaan, $results->tanggal_akhir_pengadaan);
        $tender->contractPeriod = $this->getPeriod($results->tanggal_awal_pekerjaan, $results->tanggal_akhir_pekerjaan);
        $tender->mainProcurementCategory = $this->getMainProcurementCategory($results);
        $tender->procuringEntity = $this->getOrganizationReferenceByName($year, $results->satuan_kerja, "procuringEntity", $parties);
        $tender->numberOfTenderers = $this->getNumberOfTenderers($results->sirupID);
        $tender->milestones = $this->getTenderMilestones($results->sirupID);
        return $tender;
    }

    function getNonTender($year, $results, &$parties)
    {
        $tender = new stdClass();
        $tender->id = $this->getNonLelangID($results->sirupID);
        $tender->procurementMethod = $this->getProcurementMethod($results->metode_pengadaan);
        $tender->tenderPeriod = $this->getPeriod($results->tanggal_awal_pengadaan, $results->tanggal_akhir_pengadaan);
        $tender->contractPeriod = $this->getPeriod($results->tanggal_awal_pekerjaan, $results->tanggal_akhir_pekerjaan);
        $tender->mainProcurementCategory = $this->getMainProcurementCategory($results);
        $tender->procuringEntity = $this->getOrganizationReferenceByName($year, $results->satuan_kerja, "procuringEntity", $parties);
        $tender->milestones = $this->getNonTenderMilestones($this->getNonLelangID($results->sirupID));
        return $tender;
    }

    function getProcurementMethod($internalProcurementMethodId)
    {
        if (in_array($internalProcurementMethodId, [1, 2, 9, 10, 11, 12]))
            return "open";

        if ($internalProcurementMethodId == 3)
            return "limited";

        if (in_array($internalProcurementMethodId, [4, 5]))
            return "open";

        if (in_array($internalProcurementMethodId, [6, 7, 8]))
            return "direct";

        abort(404, 'Cannot convert ' . $internalProcurementMethodId . ' to any OCDS procurementMethod!');
        return null;
    }

    function getNonCompetitiveContracts($year, $pekerjaanID, &$parties) {
        $db  = env('DB_CONTRACT');
        $sql = "SELECT
                    tpekerjaan.pid,
                    tkontrak_penunjukan.id ,
                    CONCAT(REPLACE(tpekerjaan.tanggalrencana, '-' ,''), '.', tpekerjaan.pid, '.', tpekerjaan.saltid) AS awardid,
                    TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(tpekerjaan.namapekerjaan ,'&mdash;' , 1), '&mdash;' ,- 1)) AS namapekerjaan,
                    TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(tpekerjaan.namapekerjaan ,'&mdash;' , 2), '&mdash;' ,- 1)) AS deskripsi,
                    tkontrak_penunjukan.spk_nosurat,
                    tkontrak_penunjukan.spk_tgl_surat,
                    tkontrak_penunjukan.spk_tgl_slskontrak,
                    tpengadaan.nilai_nego
                FROM
                    " .$db. ".tpekerjaan
                LEFT JOIN " .$db. ".tpengadaan ON tpengadaan.pid = tpekerjaan.pid
                LEFT JOIN " .$db. ".tkontrak_penunjukan ON tkontrak_penunjukan.pgid = tpengadaan.pgid
                WHERE
                    pekerjaanid = " .$pekerjaanID. " ";
        $results = DB::select($sql);

        $contracts = [];
        foreach ($results as $row) {
            array_push($contracts, $this->getNonCompetitiveContract($year, $row, $parties));
        }

        return $contracts;    
    }

    function getNonCompetitiveContract($year, $row, &$parties)
    {
        $ContractDateFormat = 'Y-m-d H:i:s';

        $a = new stdClass();
        $a->id = $row->pid;
        $a->awardID  = $row->awardid;
        $a->title = $row->namapekerjaan;
        $a->title = $row->deskripsi;
        if (($row->spk_nosurat != "") && ($row->spk_tgl_surat != "0000-00-00")) {
            $a->status = "active";
        } else {
            $a->status = "pending";
        }
        
        $a->period = array(
            'startDate' => $this->getOcdsDateFromString($row->spk_tgl_surat, $ContractDateFormat),
            'endDate' => $this->getOcdsDateFromString($row->spk_tgl_slskontrak, $ContractDateFormat)
            );
        $a->value = $this->getAmount($row->nilai_nego);
        $a->items = $this->getNonCompetitiveItems($row->pid);
        $a->dateSigned = $this->getOcdsDateFromString($row->spk_tgl_surat, $ContractDateFormat);
        return $a;
    }

    function getNonCompetitiveItems($pid) {
        $db = env('DB_CONTRACT');
        $sql = "SELECT 
                    tpengadaan_rincian.ID,
                    nama,
                    (SUBSTRING_INDEX(SUBSTRING_INDEX(volume ,'|' , 1), '|' ,-1) *
                     SUBSTRING_INDEX(SUBSTRING_INDEX(volume ,'|' , 2), '|' ,-1)) AS volume,
                     satuan 
                FROM " . $db . ".tpengadaan_rincian 
                LEFT JOIN " . $db . ".tpenawaran_rincian ON tpengadaan_rincian.ID = tpenawaran_rincian.pengadaan_rincian_id
                WHERE pid = " . $pid . " AND nilai_akhir <> 0";
        $results = DB::select($sql);

        $items = [];
        foreach ($results as $row) {
            array_push($items, $this->getItem($row));
        }

        return $items;
    }

    function getItem($row)
    {
        $a = new stdClass();
        $a->id = $row->ID;
        $a->description = $row->nama;
        $a->quantity = $row->volume;
        $a->unit = $this->getUnit($row->satuan);

        return $a;
    }
    
    /**
     * You should return here only initiaion type allowed by ocds. Example 'tender'. This is NOT an open code-type,
     * so you cannot use any string you like here.
     * Schema will not allow you to return anything else.
     * @param $results
     * @return string
     */
    function getInitiationType($results)
    {
        return 'tender'; //currently ocds supports tender
        //TODO: please fix this, you are not allowed to return these types internal types as ocds
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
        return $initiationType;
    }

    /**
     * Converts string dates in bandung db into JSON compliant string using DATE_ATOM format
     * @param $date
     * @param $format the format for the input date, default is 'Y-m-d'
     * @return string
     */
    function getOcdsDateFromString($date, $format = 'Y-m-d')
    {
        return DateTime::createFromFormat($format, $date)->format(DATE_ATOM);
    }

    function getNewContract($ocid)
    {
        $r = new stdClass();
        $r->ocid = $ocid;

        $pieces = explode("-", $ocid);
        $source    = $pieces[2]; // s = sirup.lkpp.go.id. b = birms.bandung.go.id
        $year      = $pieces[3];
        $sirup_id  = $pieces[4];
        
        $dbplanning = env('DB_PLANNING');
        $dbprime = env('DB_PRIME');

        if ($source == 's') {
            $sql = "SELECT * FROM ".$dbplanning.".tbl_sirup WHERE sirupID = '" . $sirup_id . "'";
        } else {
            $sql = "SELECT
            tbl_pekerjaan.pekerjaanID AS sirupID,
            ".$year." AS tahun ,
            namapekerjaan AS nama ,
            anggaran AS pagu ,
            tbl_sumberdana.sumberdana AS sumber_dana_string ,
            1 AS jenis_belanja ,
            tbl_metode.jenisID AS jenis_pengadaan ,
            (
                CASE
                WHEN tbl_metode.nama = 'Belanja Sendiri' THEN
                    9
                WHEN tbl_metode.nama = 'Kontes / Sayembara' THEN
                    10
                WHEN tbl_metode.nama = 'Pelelangan Sederhana' THEN
                    2
                WHEN tbl_metode.nama = 'Pelelangan Umum' THEN
                    1
                WHEN tbl_metode.nama = 'Pembelian Secara Elektronik' THEN
                    9
                WHEN tbl_metode.nama = 'Pemilihan Langsung' THEN
                    6
                WHEN tbl_metode.nama = 'Pengadaan Langsung' THEN
                    8
                WHEN tbl_metode.nama = 'Penunjukan Langsung' THEN
                    7
                ELSE
                    0
                END
            ) AS metode_pengadaan ,
            2 AS jenis ,
            pilih_start AS tanggal_awal_pengadaan ,
            pilih_end AS tanggal_akhir_pengadaan ,
            laksana_start AS tanggal_awal_pekerjaan ,
            laksana_end AS tanggal_akhir_pekerjaan ,
            satker AS id_satker ,
            'Kota Bandung' AS kldi ,
            tbl_skpd.nama AS satuan_kerja ,
            tbl_skpd.alamat AS lokasi ,
            IF (tbl_metode.nama = 'Swakelola' , 1 , 0) AS isswakelola
        FROM
            ".$dbplanning.".tbl_pekerjaan
        LEFT JOIN ".$dbplanning.".tbl_sumberdana ON tbl_pekerjaan.sumberdanaID = tbl_sumberdana.sumberdanaID
        LEFT JOIN ".$dbprime.".tbl_skpd ON tbl_pekerjaan.skpdID = tbl_skpd.skpdID
        LEFT JOIN ".$dbplanning.".tbl_metode ON tbl_pekerjaan.metodeID = tbl_metode.metodeID
        WHERE tbl_pekerjaan.pekerjaanID = '". $sirup_id."'";    
        }
        //die($sql);
        $results = DB::select($sql);

        if (sizeof($results) == 0) {
            abort(404, 'Cannot find contract with ocid=' . $ocid);
        }

        $results = $results[0];

        $r->id = $sirup_id;
        $r->parties = [];
        $r->tag = ['planning'];
        $r->initiationType = $this->getInitiationType($results);
        
        if ($source == 's') {
            $r->date = $this->getOcdsDateFromString($results->tanggal_awal_pengadaan);
        } else {
            if (isset($results->pilihstart)) {
                $r->date = $this->getOcdsDateFromString($results->pilih_start);
            } else {
                $r->date = $this->getOcdsDateFromString('0000-00-00');
            }
        }
        $r->planning = $this->getPlanning($results);

        if ($source == 's') {
            $r->tender = $this->getTender($year, $results, $r->parties);
        } else {
            $r->tender = $this->getNonTender($year, $results, $r->parties);
        }

        $r->buyer = $this->getOrganizationReferenceByName($year, $results->satuan_kerja, "buyer", $r->parties);
        if ($source == 's') {
            $r->awards = $this->getCompetitiveAwards($year, $sirup_id, $r->parties);
        } else {
            $r->awards = $this->getNonCompetitiveAwards($year, $sirup_id, $r->parties);
            $r->contracts = $this->getNonCompetitiveContracts($year, $sirup_id, $r->parties);
        }
                //this creates real OCDS release object and runs basic schema validation
        $validatedRelease = new OcdsRelease($r, $this->getOcdsSchema());
        return $validatedRelease->getJsonResponse(response());
    }


    function get_contract($ocid)
    {


        /*------------------------------*/
        /* Settings
        /*------------------------------*/

        $dbplanning = env('DB_PLANNING');
        $dbcontract = env('DB_CONTRACT');
        $dbmain = env('DB_PRIME');

        /*------------------------------*/
        /* General
        /*------------------------------*/

        $id = '1';
        $tag = 'planning';

        $pieces = explode("-", $ocid);
        $sirup_id = $pieces[2];
        $pgid = '';

        /*------------------------------*/
        /* Planning Stage
        /*------------------------------*/

        $sql = "select * from tbl_sirup where sirupID = '" . $sirup_id . "' ";

        $results = DB::select($sql);
        $results = $results[0];

        $date = $results->tanggal_awal_pengadaan;
        $ocid = env('OCID') . $results->sirupID;
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


        $planning_value = array('amount' => $results->pagu, 'currency' => env('CURRENCY'));

        ///compiling all stages together
        $planning_stage = array('contract_name' => $contract_name,
            'city' => $city,
            'unit' => $unit,
            'planning_value' => $planning_value);

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
                                sirupID = " . $sirup_id . " AND $dbplanning.tbl_pekerjaan.namapekerjaan = '" . $contract_name . "'";

            $results = DB::select($sql_selection);

            if (!empty($results)) {
                $results = $results[0];

                $winning_bidder = $results->perusahaannama;
                $award_amount = $results->nilai;
                $pgid = $results->pgid;

                $list_of_items_sql = "select * from $dbcontract.tpengadaan_rincian where pgid = '" . $pgid . "' ";
                $items = DB::select($list_of_items_sql);
            }

        } else { //Lelang (Competitive)
            $sql_selection = "select * from $dbcontract.tlelangumum where sirupID = '" . $sirup_id . "' ";
            $results = DB::select($sql_selection);

            if (!empty($results)) {
                $results = $results[0];

                $winning_bidder = $results->pemenang;
                $award_amount = $results->nilai_nego;
                $items = "";
            }
        }

        //build the award stage
        $award_stage = array('winning_bidder' => $winning_bidder,
            'award_amount' => $award_amount,
            'items' => $items);


        /*------------------------------*/
        /* Release
        /*------------------------------*/
        $release = array('ocid' => $ocid,
            'id' => $id,
            'date' => $date,
            'tag' => $tag,
            'initiationType' => $initiationType,
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
