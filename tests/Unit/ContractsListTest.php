<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 7/6/18
 * Time: 12:23 PM
 */

namespace Tests\Unit;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Storage;
use stdClass;
use Tests\TestCase;
use GuzzleHttp\Client;


class ContractsListTest extends TestCase
{

    public function testContracts() {
        $this->testContractsList(2016);
    }

    private function testContractsList($year)
    {
        $fileName="testContractList".$year.".json";
        $client = new Client(['verify' => false]);

            $uri="http://birms.bandung.go.id/beta/api/contracts/year/".$year;

            while ($uri != null) {
                $res = $client->request('GET', $uri);
                error_log('Retrieved '.$uri);

                $contents = json_decode($res->getBody()->getContents());

                foreach ($contents->data as $element) {
                    $this->testOcdsUrl($client, $element->uri, $element->ocid, $fileName);
                }
                $uri=$contents->next_page_url;
            }

    }

    private function testOcdsUrl($client, $url, $ocid, $fileName) {
        try {
            error_log('Retrieve '.$url);
            $res = $client->request('GET', $url);
            //Storage::disk('public')->append($fileName, $ocid." ".$url." OK");
        } catch (RequestException $e) {
            $o=new stdClass();
            $o->ocid=$ocid;
            $o->url=$url;
            $o->result="Error";
            Storage::disk('public')->append($fileName, json_encode( $o, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        }
    }
}