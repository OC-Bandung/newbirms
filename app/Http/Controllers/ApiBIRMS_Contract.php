<?php

namespace App\Http\Controllers;

use DateTime;
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
        return $response->make($this->toJson())->header('Content-Type', 'application/json');
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

    function getOrganizationByName($name)
    {
        $db = env('DB_PRIME');
        $sql = "select * from " . $db . ".tbl_skpd where nama = '" . $name . "'";
        $results = DB::select($sql);
        if (sizeof($results) == 0) {
            abort(404, 'No organization found by name ' . $name);
        }

        $row = $results[0];

        $org = new stdClass();
        $org->id = $row->unitID;
        $org->name = $row->nama;
        $org->address = $this->getAddress($row);
        $org->contactPoint = $this->getContactPoint($row);

        $id = new stdClass();
        $id->id = $row->unitID;
        $id->legalName = $row->nama;
        $org->identifier = $id;

        return $org;
    }

    function getOrganizationReferenceByName($name, $role, &$parties)
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
            $org = $this->getOrganizationByName($name);
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
        $reference->id = $org->id;
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

    function getNumberOfTenderers($sirupID)
    {
        $db = env('DB_CONTRACT');
        $sql = "select * from " . $db . ".tlelangumum where sirupID = " . $sirupID . " ";
        $results = DB::select($sql);
        if (sizeof($results) == 0) {
            abort(404, 'No procurement found by sirupID ' . $sirupID);
        }
        $row = $results[0];

        $bidder = (int)$row->jumlah_peserta;
        return $bidder;
    }

    function getTenderMilestones($sirupID)
    {
        $db = env('DB_CONTRACT');
        $milestoneDateFormat = 'Y-m-d H:i:s';
        $sql = "select * from " . $db . ".tlelangumum where sirupID = " . $sirupID . " ";
        $results = DB::select($sql);
        if (sizeof($results) == 0) {
            abort(404, 'No procurement found by sirupID ' . $sirupID);
        }
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

        return $milestones;
    }


    function getCompetitiveAward($row, &$parties)
    {
        $a = new stdClass();
        $a->id = $row->lgid;
        $a->title = $row->namapekerjaan;
        $a->date = $this->getOcdsDateFromString($row->tanggalpengumuman);
        $a->status = "active";
        $a->value = $this->getAmount($row->nilai_nego);
        //$a->suppliers = [$this->getOrganizationReferenceByName($row->pemenang, "supplier", $parties)];
        return $a;
    }

    function getCompetitiveAwards($sirupID, &$parties)
    {
        $db = env('DB_CONTRACT');
        $sql = "select * from " . $db . ".tlelangumum where sirupID = " . $sirupID . " ";
        $results = DB::select($sql);

        $awards = [];
        foreach ($results as $row) {
            array_push($awards, $this->getCompetitiveAward($row, $parties));
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

    function getTenderMilestone($row)
    {
        $milestoneDateFormat = 'Y-m-d H:i:s';
        $milestone = new stdClass();
        $milestone->id = $row->akt_id;
        $milestone->title = $row->akt_jenis;
        $milestone->description = $row->dtj_keterangan;
        $milestone->dueDate = $this->getOcdsDateFromString($row->dtj_tglakhir, $milestoneDateFormat);
        $milestone->dateMet = $this->getOcdsDateFromString($row->dtj_tglawal, $milestoneDateFormat);
        $milestone->dateModified = $this->getOcdsDateFromString($row->auditupdate, $milestoneDateFormat);
        $milestone->status = $this->getMilestoneStatus($row->dtj_tglakhir, $row->dtj_tglawal);
        //$milestone->status = $row->akt_status; //TODO: titan we need a mapping here between akt_status and milestone
        //status http://standard.open-contracting.org/1.1/en/schema/codelists/#milestone-status
        return $milestone;
    }

    function getTender($results, &$parties)
    {
        $tender = new stdClass();
        $tender->id = $results->sirupID;
        $tender->procurementMethod = $this->getProcurementMethod($results->metode_pengadaan);
        $tender->tenderPeriod = $this->getPeriod($results->tanggal_awal_pengadaan, $results->tanggal_akhir_pengadaan);
        $tender->contractPeriod = $this->getPeriod($results->tanggal_awal_pekerjaan, $results->tanggal_akhir_pekerjaan);
        $tender->mainProcurementCategory = $this->getMainProcurementCategory($results);
        $tender->procuringEntity = $this->getOrganizationReferenceByName($results->satuan_kerja, "procuringEntity", $parties);
        $tender->numberOfTenderers = $this->getNumberOfTenderers($results->sirupID);
        $tender->milestones = $this->getTenderMilestones($results->sirupID);
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
        $sirup_id = $pieces[2];
        $sql_intro = "select * from tbl_sirup where sirupID = '" . $sirup_id . "' ";
        $results = DB::select($sql_intro);

        if (sizeof($results) == 0) {
            abort(404, 'Cannot find contract with ocid=' . $ocid);
        }

        $results = $results[0];

        $r->id = $sirup_id;
        $r->parties = [];
        $r->tag = ['planning'];
        $r->initiationType = $this->getInitiationType($results);
        $r->date = $this->getOcdsDateFromString($results->tanggal_awal_pengadaan);
        $r->planning = $this->getPlanning($results);
        $r->tender = $this->getTender($results, $r->parties);
        $r->buyer = $this->getOrganizationReferenceByName($results->satuan_kerja, "buyer", $r->parties);
        $r->awards = $this->getCompetitiveAwards($sirup_id, $r->parties);


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

        $sql_intro = "select * from tbl_sirup where sirupID = '" . $sirup_id . "' ";

        $results = DB::select($sql_intro);
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
