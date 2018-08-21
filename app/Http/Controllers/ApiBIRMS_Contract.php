<?php

namespace App\Http\Controllers;

use App\Dto\CustomDtoServiceContainer;
use DateTime;
use Dto\JsonSchemaRegulator;
use Dto\ServiceContainer;
use Illuminate\Contracts\Routing\ResponseFactory;
use Dto\Dto;
use Illuminate\Http\Request;
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

    function getJsonpResponse(ResponseFactory $response, Request $request)
    {
        $callback=$request->get("callback");
        return $response->make($callback.'('.$this->toJson(true).')')
            ->header('Content-Type', 'application/javascript');
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

    function getOrganizationByName($year, $name, $competitive)
    {
        $name = preg_replace('/\s+/', ' ', $name);

        if ($year <= 2016) {
            $db = env('DB_PRIME_PREV');
        } else {
            $db = env('DB_PRIME');
        }
        $dbeproc = env('DB_EPROC');
        $dbecontract = env('DB_CONTRACT');

        if ($competitive === false) {
            $sql = "SELECT perusahaanID, npwp, namaperusahaan, alamatperusahaan, kota, telepon, fax, email FROM " . $dbeproc . ".tperusahaan WHERE UCASE(REPLACE(namaperusahaan, '  ', ' ')) = UCASE('".$name."') ";
            $results = DB::select($sql);

            if (sizeof($results) == 0) {
                $sql = "SELECT perusahaanid AS perusahaanID, perusahaannpwp AS npwp, perusahaannama AS namaperusahaan, perusahaanalamat AS alamatperusahaan, NULL AS kota, NULL AS telepon, NULL AS fax, NULL AS email  FROM " . $dbecontract . ".tpengadaan_pemenang  WHERE UCASE(REPLACE(perusahaannama, '  ', ' ')) = UCASE('".$name."') ";
                $results = DB::select($sql);
            }
        } else if ($competitive === true) {
            if (strpos($name, ".") === false) {
                $findname = $name;
            } else {
                $pieces   = explode(".", $name);
                $findname = TRIM($pieces[1]);
            }
            $sql = "SELECT * FROM " . $dbecontract . ".lpse_rekanan WHERE UCASE(rkn_nama) LIKE '%".$findname."%'";
        } else {
            $sql = "SELECT * FROM " . $db . ".tbl_skpd WHERE UCASE(nama) = UCASE('" . $name . "')";
        }
        //die($sql);
        $results = DB::select($sql);
        
        $org = new stdClass();

        if (sizeof($results) == 0) {
            //abort(404, 'No organization found by name ' . $name);
            $org->name = $name;
        } else {
            $row = $results[0];
            
            if ($competitive === false) {
                $org->id = $row->npwp;
                $org->name = $row->namaperusahaan;
                $org->address = $this->getAddressPerusahaan($row);
                $org->contactPoint = $this->getContactPoint($row); 
                
                $id = new stdClass();
                $id->id = $row->npwp;
                $id->legalName = $row->namaperusahaan;
                $org->identifier = $id;
            } else if ($competitive === true) {
                $org->id = $row->rkn_npwp;
                $org->name = $row->rkn_nama;
                
                $address = new stdClass();
                $address->streetAddress = $row->rkn_alamat;
                $org->address = $address;

                $cp = new stdClass();
                $cp->email = $row->rkn_email;
                $cp->telephone = $row->rkn_telepon;
                $org->contactPoint = $cp; 
                
                $id = new stdClass();
                $id->id = $row->rkn_npwp;
                $id->legalName = $row->rkn_nama;
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
        }
        return $org;
    }

    function getOrganizationReferenceByName($year, $name, $role, &$parties, $orgObj, $competitive = null)
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
            if(isset($orgObj)) {
                $org=$orgObj;
            } else {
                    $org = $this->getOrganizationByName($year, $name, $competitive);
            }
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
        if ($results->jenis_pengadaan == 1) {
            return "goods";
        } else if ($results->jenis_pengadaan == 2) {
            return "works";
        } else if ($results->jenis_pengadaan == 3) {
            return "services";
        } else if ($results->jenis_pengadaan == 4) {
            return "services";
        } else {
            return null;
        }
        abort(404, 'No main procurement category can be mapped for  code ' . $results->jenis_pengadaan);
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
   
    function getRegistrant($row, $year,  &$parties)
    {
        $registrant = new stdClass();
        $registrant->id = $row->rkn_npwp;
        $registrant->name = $row->rkn_nama;
        
        $address = new stdClass();
        $address->streetAddress = $row->rkn_alamat;
        $registrant->address = $address;

        $cp = new stdClass();
        $cp->email = $row->rkn_email;
        $cp->telephone = $row->rkn_telepon;
        $registrant->contactPoint = $cp;
        
        $id = new stdClass();
        $id->id = $row->rkn_npwp;
        $id->legalName = $row->rkn_nama;
        $registrant->identifier = $id;

        return $this->getOrganizationReferenceByName($year, $row->rkn_nama, "registrant", $parties, $registrant);
    }

    function registerRegistrants($tender_id, $year,  &$parties)
    {
        $db = env('DB_CONTRACT');
        $sql = "SELECT * FROM ".$db.".lpse_peserta 
                LEFT JOIN ".$db.".lpse_rekanan ON lpse_peserta.rkn_id = lpse_rekanan.rkn_id
                WHERE lls_id = ". $tender_id ." ORDER BY lpse_peserta.auditupdate ASC";
        $results = DB::select($sql);

        if (sizeof($results) == 0) {
        } else {
            foreach ($results as $row) {
               $this->getRegistrant($row, $year,$parties);
            }
        }
    }

    /**
     * @param $sirupID
     * @return int
     * @deprecated
     */
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

            /*if (sizeof($results) == 0) {
                abort(404, 'No milestone found by lelang ID ' . $lls_id);
            }*/

            $milestones = [];
            if (sizeof($results) != 0) {
                foreach ($results as $row) {
                    array_push($milestones, $this->getTenderMilestone($row));
                }
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
                WHERE pid = " . $pID . " ORDER BY tmaster_tahap.urutan";
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
        //$supl->id = TODO: set the supplier id here !!

        $orgId      = new stdClass();
        $orgId->legalName=$row->perusahaannama;
        $supl->identifier=$orgId;

        $addr=new stdClass();
        $addr->streetAddress=$row->perusahaanalamat;
        $supl->address=$addr;

        $a->suppliers = [$this->getOrganizationReferenceByName($year, $row->perusahaannama, "supplier", $parties, $supl, false)];
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
            //$supl->id = TODO: set the supplier id here !!
            
            $orgId      = new stdClass();
            $orgId->legalName=$row->pemenang;
            $supl->identifier=$orgId;

            $addr=new stdClass();
            $addr->streetAddress=$row->pemenangalamat;
            $supl->address=$addr;

            $a->suppliers = [$this->getOrganizationReferenceByName($year, $row->pemenang, "supplier", $parties, $supl, true)];
        } else {
            $a->status = "pending";
        }
        return $a;
    }

    function getNonCompetitiveAwards($year, $pekerjaanID, &$parties) {
        $db = env('DB_CONTRACT');
        $sql = "SELECT
                    CONCAT(
                        REPLACE ( tpekerjaan.tanggalrencana, '-', '' ),
                        '.',
                        tpekerjaan.pid,
                        '.',
                        tpekerjaan.saltid 
                    ) AS id,
                    tbl_pekerjaan.namapekerjaan,
                    pilih_start,
                    nilai_nego,
                    perusahaanid,
                    perusahaannama,
                    perusahaanalamat,
                    perusahaannpwp 
                FROM
                    tbl_pekerjaan
                    LEFT JOIN ".$db.".tpekerjaan ON tbl_pekerjaan.pekerjaanID = tpekerjaan.pekerjaanID
                    LEFT JOIN ".$db.".tpengadaan ON tpekerjaan.pid = tpengadaan.pid
                    LEFT JOIN ".$db.".tpengadaan_pemenang ON tpengadaan.pgid = tpengadaan_pemenang.pgid 
                WHERE
                    tbl_pekerjaan.pekerjaanID = ". $pekerjaanID . " AND tpekerjaan.pekerjaanstatus >= 4"; //4: Berjalan 7:Selesai
        //die($sql);
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
        return $milestone;
    }

    function getTenderMilestone($row)
    {
        $milestoneDateFormat = 'Y-m-d H:i:s';

        $row->akt_jenis = ucwords(strtolower(preg_replace('/_/', ' ', $row->akt_jenis)));
        $milestone = new stdClass();
        $milestone->id = $row->akt_id;
        $milestone->title = $row->akt_jenis;
        $milestone->description = $row->dtj_keterangan;
        $milestone->dueDate = $this->getOcdsDateFromString($row->dtj_tglakhir, $milestoneDateFormat);
        $milestone->dateMet = $this->getOcdsDateFromString($row->dtj_tglawal, $milestoneDateFormat);
        //$milestone->dateModified = $this->getOcdsDateFromString($row->auditupdate, $milestoneDateFormat);
        $milestone->status = $this->getMilestoneStatus($row->dtj_tglakhir, $row->dtj_tglawal);
        return $milestone;
    }

    /**
     * This function has parts of getTender that are common for getTender and getNonTender
     *
     * @param $year
     * @param $results
     * @param $parties
     * @return stdClass
     */
    function getSharedTender($year, $results, &$parties)
    {
        $tender = new stdClass();
        $tender->procurementMethod = $this->getProcurementMethod($results->metode_pengadaan);
        $tender->tenderPeriod = $this->getPeriod($results->tanggal_awal_pengadaan, $results->tanggal_akhir_pengadaan);
        $tender->contractPeriod = $this->getPeriod($results->tanggal_awal_pekerjaan, $results->tanggal_akhir_pekerjaan);
        $tender->mainProcurementCategory = $this->getMainProcurementCategory($results);
        $tender->procuringEntity = $this->getOrganizationReferenceByName($year, $results->satuan_kerja, "procuringEntity", $parties, null, null);

        return $tender;
    }

    function getTender($year, $results, &$parties) {
        $db = env('DB_CONTRACT');
        
        $tender = $this->getSharedTender($year, $results, $parties);
        $tender->id = $this->getLelangID($results->sirupID);
        $tender->milestones = $this->getTenderMilestones($results->sirupID);

        $sql = "SELECT * FROM " . $db . ".tlelangumum WHERE sirupID = " . $results->sirupID . " ";
        $results = DB::select($sql);

        if (sizeof($results) == 0) {
            $tender->numberOfTenderers = 0;
        } else {
            $tender->value=$this->getAmount($results[0]->nilai_nego);
            $tender->tenderers=$this->getTenderers($results[0]->lls_id);
            $tender->numberOfTenderers = sizeof($tender->tenderers);
            $this->registerRegistrants($results[0]->lls_id, $year, $parties);
            $tender->status=$this->getSharedTenderStatus($results[0]->pekerjaanstatus); //TODO: Check again mapping status
            $tender->title=$results[0]->namapekerjaan;
        }

        return $tender;
    }

    function getSharedTenderStatus($status)
    {
        if (($status == 1) || ($status == 2) || ($status == 3)) {
            return "planned";
        } else if (($status == 4) || ($status == 5)) {
            return "active";
        } else if ($status == 6) {
            return "unsuccesful";
        } else if ($status == 7) {
            return "complete";
        } else {
            return "withdrawn";
        }
    }

    function getNonTender($year, $results, &$parties)
    {
        $db = env('DB_CONTRACT');

        $tender = $this->getSharedTender($year, $results, $parties);
        $tender->id = $this->getNonLelangID($results->sirupID);
        $tender->milestones = $this->getNonTenderMilestones($this->getNonLelangID($results->sirupID));

        $sql = "SELECT
                    CONCAT(
                        REPLACE ( tpekerjaan.tanggalrencana, '-', '' ),
                        '.',
                        tpekerjaan.pid,
                        '.',
                        tpekerjaan.saltid 
                    ) AS id,
                    tbl_pekerjaan.namapekerjaan,
                    pilih_start,
                    nilai_nego,
                    perusahaanid,
                    perusahaannama,
                    perusahaanalamat,
                    perusahaannpwp,
                    tpekerjaan.pekerjaanstatus 
                FROM
                    tbl_pekerjaan
                    LEFT JOIN ".$db.".tpekerjaan ON tbl_pekerjaan.pekerjaanID = tpekerjaan.pekerjaanID
                    LEFT JOIN ".$db.".tpengadaan ON tpekerjaan.pid = tpengadaan.pid
                    LEFT JOIN ".$db.".tpengadaan_pemenang ON tpengadaan.pgid = tpengadaan_pemenang.pgid 
                WHERE
                    tbl_pekerjaan.pekerjaanID = ". $results->sirupID . " AND (NOT ISNULL(perusahaanid) OR perusahaanid <> '')";
        $rsnontender = DB::select($sql);

        $tender->numberOfTenderers = count($rsnontender); //Total tenderers from Non Competitive / Direct Procurement
        
        if (sizeof($rsnontender) <> 0) {
            $sql = "SELECT SUM(nilai_nego) AS jumlah_nilai FROM tbl_pekerjaan
                    LEFT JOIN ".$db.".tpekerjaan ON tbl_pekerjaan.pekerjaanID = tpekerjaan.pekerjaanID
                    LEFT JOIN ".$db.".tpengadaan ON tpekerjaan.pid = tpengadaan.pid
                    LEFT JOIN ".$db.".tpengadaan_pemenang ON tpengadaan.pgid = tpengadaan_pemenang.pgid 
                WHERE
                    tbl_pekerjaan.pekerjaanID = ". $results->sirupID . " AND (NOT ISNULL(perusahaanid) OR perusahaanid <> '')";
            $rscount = DB::select($sql);

            $tender->value=$this->getAmount($rscount[0]->jumlah_nilai);
            $tender->status=$this->getSharedTenderStatus($rsnontender[0]->pekerjaanstatus); //TODO:
            $tender->title=$rsnontender[0]->namapekerjaan;
       }

        return $tender;
    }

    function getProcurementMethod($internalProcurementMethodId)
    {
        if (in_array($internalProcurementMethodId, [1, 2, 3, 4, 5, 9, 10, 11, 12]))
            return "open";

        if (in_array($internalProcurementMethodId, [0, 3]))
            return "limited";

        if (in_array($internalProcurementMethodId, [6, 7, 8, 21])) // Note 21 = Swakelola
            return "direct";

        abort(404, 'Cannot convert ' . $internalProcurementMethodId . ' to any OCDS procurementMethod!');
        return null;
    }

    function getNonCompetitiveContracts($year, $pekerjaanID, &$parties) 
    {
        $db  = env('DB_CONTRACT');
        $sql = "SELECT
                    tpekerjaan.pid,
                    CONCAT(
                        REPLACE ( tpekerjaan.tanggalrencana, '-', '' ),
                        '.',
                        tpekerjaan.pid,
                        '.',
                        tpekerjaan.saltid 
                    ) AS awardid,
                    TRIM(
                        SUBSTRING_INDEX(
                            SUBSTRING_INDEX( tpekerjaan.namapekerjaan, '—', 1 ),
                            '—',- 1 
                        ) 
                    ) AS namapekerjaan,
                    TRIM(
                        SUBSTRING_INDEX(
                            SUBSTRING_INDEX( tpekerjaan.namapekerjaan, '—', 2 ),
                            '—',- 1 
                        ) 
                    ) AS deskripsi,
                    tkontrak_penunjukan.spk_nosurat,
                    tkontrak_penunjukan.spk_tgl_surat,
                    tkontrak_penunjukan.spk_tgl_slskontrak,
                    tpengadaan.nilai_nego 
                FROM
                    " .$db. ".tpekerjaan
                    LEFT JOIN " .$db. ".tpengadaan ON tpengadaan.pid = tpekerjaan.pid
                    LEFT JOIN " .$db. ".tkontrak_penunjukan ON tkontrak_penunjukan.pgid = tpengadaan.pgid 
                WHERE
                    " .$db. ".tpekerjaan.pekerjaanstatus >= 4 
                    AND pekerjaanid = ".$pekerjaanID." 
                    AND (
                        NOT ISNULL( spk_nosurat ) 
                        AND NOT ISNULL( spk_tgl_surat ) 
                        AND NOT ISNULL ( tkontrak_penunjukan.spk_tgl_slskontrak ) 
                    ) 
                    GROUP BY tpekerjaan.pid, awardid, namapekerjaan, deskripsi, tkontrak_penunjukan.spk_nosurat,
                    tkontrak_penunjukan.spk_tgl_surat,
                    tkontrak_penunjukan.spk_tgl_slskontrak,
                    tpengadaan.nilai_nego";
        
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

    function getNonCompetitiveItems($pid) 
    {
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
        /*$metode = $results->metode_pengadaan;
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
        return $initiationType;*/
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

    /**
     * Adds ocds tag based on existing data about phases
     *
     * @param $r the release
     */
    function appendTag($r) 
    {
        if(property_exists ($r, "tender")) {
            array_push($r->tag, "tender");
        }

        if(property_exists ($r, "awards") && !empty($r->awards)) {
            array_push($r->tag, "award");
        }

        if(property_exists ($r, "contracts") && !empty($r->contracts)) {
            array_push($r->tag, "contract");
        }
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
        $dbcontract = env('DB_CONTRACT');

        if ($year <= 2016) {
            $dbprime = env('DB_PRIME_PREV');
        } else {
            $dbprime = env('DB_PRIME');
        }

        if ($source == 's') {
            $sql = "SELECT * FROM ".$dbplanning.".tbl_sirup WHERE sirupID = '" . $sirup_id . "'";
        } else {
            $sql = "SELECT
                    tbl_pekerjaan.pekerjaanID AS sirupID,
                    ".$year." AS tahun ,
                    tbl_pekerjaan.namapekerjaan AS nama ,
                    IF(tbl_pekerjaan.anggaranp <> 0,tbl_pekerjaan.anggaranp,tbl_pekerjaan.anggaran) AS pagu ,
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
                        WHEN tbl_metode.nama = 'Swakelola' THEN
                            21
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
                    IF (tbl_metode.nama = 'Swakelola' , 1 , 0) AS isswakelola,
                    IF (ISNULL(tpekerjaan.pid),0,1) AS isready, 
                    tpekerjaan.pekerjaanstatus
                FROM
                    ".$dbplanning.".tbl_pekerjaan
                LEFT JOIN ".$dbplanning.".tbl_sumberdana ON tbl_pekerjaan.sumberdanaID = tbl_sumberdana.sumberdanaID
                LEFT JOIN ".$dbprime.".tbl_skpd ON tbl_pekerjaan.skpdID = tbl_skpd.skpdID
                LEFT JOIN ".$dbplanning.".tbl_metode ON tbl_pekerjaan.metodeID = tbl_metode.metodeID
                LEFT JOIN ".$dbcontract.".tpekerjaan ON tbl_pekerjaan.pekerjaanID = tpekerjaan.pekerjaanID
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
            if (isset($results->tanggal_awal_pengadaan)) {
                $r->date = $this->getOcdsDateFromString($results->tanggal_awal_pengadaan);
            } else {
                $r->date = $this->getOcdsDateFromString('0000-00-00');
            }
        }
        $r->planning = $this->getPlanning($results);

        if ($source == 's') {
            $r->tender = $this->getTender($year, $results, $r->parties);
        } else {
            if ($results->isready) {
                $r->tender = $this->getNonTender($year, $results, $r->parties);
            }
        }

        $r->buyer = $this->getOrganizationReferenceByName($year, $results->satuan_kerja, "buyer", $r->parties, null, null);
        if ($source == 's') {
            $r->awards = $this->getCompetitiveAwards($year, $sirup_id, $r->parties);
        } else {
            $r->awards = $this->getNonCompetitiveAwards($year, $sirup_id, $r->parties);
            $r->contracts = $this->getNonCompetitiveContracts($year, $sirup_id, $r->parties);
        }

        $this->appendTag($r);

                //this creates real OCDS release object and runs basic schema validation
        $validatedRelease = new OcdsRelease($r, $this->getOcdsSchema());
        if(is_null(request()->get("callback"))) {
            return $validatedRelease->getJsonResponse(response());
        } else {
            return $validatedRelease->getJsonpResponse(response(), request());
        }
    }

    /* RECENT */

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

    public function get_program($year, $kode) 
    {
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
    
    function get_recent_pengadaan() 
    {
        $dbplanning = env('DB_PLANNING');
        $dbcontract = env('DB_CONTRACT');
        $dbprime    = env('DB_PRIME');
        
        $year = date('Y');
		$sql = 'SELECT
						CONCAT("'.env('OCID').'","s-",tahun,"-",sirupID) AS ocid,
						NULL AS koderekening,
						sirupID,
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
						tanggal_awal_pekerjaan,
						tanggal_akhir_pekerjaan,
						id_satker,
						kldi,
						satuan_kerja,
						lokasi,
						isswakelola, 
						NULL AS isready,
						NULL AS pekerjaanstatus,
						NULL AS created_at,
						NULL AS updated_at
				FROM
				'.$dbplanning.'.tbl_sirup
				WHERE tahun = '.$year.' AND pagu <> 0 
					UNION
					SELECT
					CONCAT( "'.env('OCID').'", "b-", '.$year.', "-", tbl_pekerjaan.pekerjaanID  ) AS ocid,
					kodepekerjaan AS koderekening,
					sirupID,
					'.$year.' AS tahun ,
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
				WHERE YEAR(tbl_pekerjaan.created) = '.$year.' AND sirupID = 0 AND iswork = 1 LIMIT 20';
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
            $data['title'] 		    = $row->nama; 
			$data['koderekening']   = $row->koderekening;
            $data['project'] 	    = $this->get_program($row->tahun, $row->koderekening);
			
            $data['sirupID'] 	    = $row->sirupID;
            $data['SKPD']		    = $row->satuan_kerja;
            $data['anggaran']       = $row->pagu;
            $data['hps']            = "";
            $data['nilai_penawaran']= "";
            
            $data['nilai_nego']     = "";
            $data['suppliers']      = "";
            $data['procurementMethod']				= $row->metode_pengadaan;
			if ($row->metode_pengadaan != 0) {
				$data['procurementMethodDetails']		= $this->metode_pengadaan($row->metode_pengadaan);
			} else {
				$data['procurementMethodDetails']		= "";
            }
            $data['awardCriteria']					= "priceOnly";
            $data['dateSigned']        = "";
            $data['contract']	= array(
                'startDate' => $row->tanggal_awal_pekerjaan,
                'endDate' => $row->tanggal_akhir_pekerjaan
            );
            $data['created_at']		= $row->created_at;
            $data['updated_at']		= $row->updated_at;

			array_push($rowdata, $data);
        }

		$results = $rowdata;

		return response()
    			->json($results)
    			->header('Access-Control-Allow-Origin', '*');
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

    function getTenderer($row)
    {
        $tenderer = new stdClass();
        $tenderer->id = $row->rkn_npwp;
        $tenderer->name = $row->rkn_nama;
        
        $address = new stdClass();
        $address->streetAddress = $row->rkn_alamat;
        $tenderer->address = $address;

        $cp = new stdClass();
        $cp->email = $row->rkn_email;
        $cp->telephone = $row->rkn_telepon;
        $tenderer->contactPoint = $cp; 
        
        $id = new stdClass();
        $id->id = $row->rkn_npwp;
        $id->legalName = $row->rkn_nama;
        $tenderer->identifier = $id; 

        return $tenderer;
    }

    private function getTenderers($lls_id)
    {
        $db = env('DB_CONTRACT');
        $sql = "SELECT * FROM ".$db.".lpse_peserta 
                LEFT JOIN ".$db.".lpse_rekanan ON lpse_peserta.rkn_id = lpse_rekanan.rkn_id
                WHERE lls_id = ". $lls_id ." AND (TRIM(psr_harga) <> '' AND TRIM(psr_harga_terkoreksi) <> '') ORDER BY lpse_peserta.auditupdate ASC";
        $results = DB::select($sql);

        if (sizeof($results) == 0) {
            //abort(404, 'No tenderers found by tender_id ' . $tender_id);
            $tenderers = [];
        } else {
            $tenderers = [];
            foreach ($results as $row) {
                array_push($tenderers, $this->getTenderer($row));
            }
        }
        return $tenderers;
    }
}
