<?php namespace App\Helpers\Titan;

use Illuminate\Support\Facades\DB;

class Myglobals {
    public static function indo_date($date) { //reformat from yyyy-mm-dd to dd mon yyyy
    	$bln = array(   1 => 'Januari', 
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember');
    	$pcs = explode("-", $date);
    	$y = $pcs[0];
    	$m = (int)$pcs[1];
    	$dum = explode(" ",$pcs[2]);
    	$d = $dum[0];
    	
    	return $d ." ". $bln[$m] ." ". $y;
    }
    
    /*Indo date short version*/
    public static function indo_dateshort($date) {
    	$pcs = explode("-", $date);
    	$d = substr($pcs[2],0,2);
    	$m = $pcs[1];
    	$y = $pcs[0];
    	return $d . "-". $m . "-". $y;
    }
    
    public static function mysqldate($date) {
    	$pcs = explode("-", $date);
    	$d = $pcs[0];
    	$m = $pcs[1];
    	$y = $pcs[2];
    	return $y . "-". $m . "-". $d;
    }
    
    public static function realip() {
        //check ip from share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }  //to check ip is pass from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    
    public static function formatBytes($b,$p = null) {
    // example 
    // formatBytes(81000000);   //returns 77.25 MB
    // formatBytes(81000000,0); //returns 81,000,000 B
    // formatBytes(81000000,1); //returns 79,102 kB

        $units = array("B","kB","MB","GB","TB","PB","EB","ZB","YB");
        $c = 0;
        if(!$p && $p !== 0) {
            foreach($units as $k => $u) {
                if(($b / pow(1024,$k)) >= 1) {
                    $r["bytes"] = $b / pow(1024,$k);
                    $r["units"] = $u;
                    $c++;
                }
            }
            return number_format($r["bytes"],2) . " " . $r["units"];
        } else {
            return number_format($b / pow(1024,$p)) . " " . $units[$p];
        }
    }

    // Start Terbilang format
    public static function moneyFormat($nominal){
        $nominal = abs($nominal);
 
        $angka = array("","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan","sepuluh","sebelas");
        $temp = "";
 
        if($nominal < 12) {
            $temp = " ".$angka[$nominal];
        } else if($nominal < 20) {
            $temp = moneyFormat($nominal - 10)." belas";
        } else if($nominal < 100) {
            $temp = moneyFormat($nominal/10)." puluh".moneyFormat($nominal % 10);
        } else if ($nominal < 200) {
            $temp = " seratus".moneyFormat($nominal - 100);
        } else if ($nominal < 1000) {
            $temp = moneyFormat($nominal/100). " ratus". moneyFormat($nominal % 100);
        } else if ($nominal < 2000) {
            $temp = " seribu". moneyFormat($nominal - 1000);
        } else if ($nominal < 1000000) {
            $temp = moneyFormat($nominal/1000)." ribu". moneyFormat($nominal % 1000);
        } else if ($nominal < 1000000000) {
            $temp = moneyFormat($nominal/1000000)." juta". moneyFormat($nominal % 1000000);
        } else if ($nominal < 1000000000000) {
            $temp = moneyFormat($nominal/1000000000)." milyar". moneyFormat($nominal % 1000000000);
        } else if ($nominal < 1000000000000000) {
            $temp = moneyFormat($nominal/1000000000000)." triliun". moneyFormat($nominal % 1000000000000);
        }
 
        return $temp;
    }

    public static function moneyDecimal($nominal) {
    	$whole = floor($nominal);      // 1
    	$nominalkoma = $nominal - $whole; //0.25	
    	
    	//Just Support 0.00 0.25 0.50 0.75
    	$angkakoma = array("","seper empat","setengah","tiga per empat");
    	$tempkoma = "";
    	if ($nominalkoma != "") {
    		 if ($nominalkoma == 0) {
    			 $tempkoma = "";
    		 } else if (($nominalkoma >= 0.1) && ($nominalkoma <= 0.25)){
    			$tempkoma = " ".$angkakoma[1];
    		 } else if (($nominalkoma >= 0.26) && ($nominalkoma <= 0.50)){
    			$tempkoma = " ".$angkakoma[2];
    		 } else if (($nominalkoma >= 0.51) && ($nominalkoma <= 0.75)){
    			$tempkoma = " ".$angkakoma[3];
    		 }
    	 }
    	 return $tempkoma;	
    }

    public static function displayNIP($nip) {
    	if (strlen($nip) == 18) {
    		$newnip = substr($nip,0,8).' '.substr($nip,8,6).' '.substr($nip,14,1).' '.substr($nip,15,3); //NIP 18 digit	
    	} else {
    		$newnip = $nip;
    	}
    	return $newnip;
    }

    public static function bulat($nilai) {
    	$pembulat = 10;
    	$newbulat = $pembulat * floor($nilai/$pembulat);
    	return $newbulat;
    }
    
    
    public static function moneyDisplay($val) {
        $nm = array(    1 => 'satu', 
                        2 => 'dua',
                        3 => 'tiga',
                        4 => 'empat',
                        5 => 'lima',
                        6 => 'enam',
                        7 => 'tujuh',
                        8 => 'delapan',
                        9 => 'sembilan');

        $nm = array(    0 => '',
                        1 => 'ribu', 
                        2 => 'juta',
                        3 => 'milyar',
                        4 => 'trilyun');
        
        $val = floatval($val);
		$count = strlen($val);

        if (($count >= 16 ) && ($count <= 18 )) {
			$result = "Rp. ". number_format($val/1000000000000000,1,',','.')." Kd";
		} else if (($count >= 13 ) && ($count <= 15 )) {
			$result = "Rp. ". number_format($val/1000000000000,1,',','.')." T";
		} else if (($count >= 10 ) && ($count <= 12 )) {
			$result = "Rp. ". number_format($val/1000000000,1,',','.')." M";
		} else {
			$result = "Rp. ". number_format($val/1000000,1,',','.')." jt";
		}
		return $result;
	}
}