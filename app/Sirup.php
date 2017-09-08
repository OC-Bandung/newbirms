<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sirup extends Model
{
	protected $appends = array('ocid' , 'year' , 'title', 'uri' , 'value' );
	
	protected $visible =  array('ocid' , 'year' , 'title' , 'value' , 'uri');
 
    protected $table = "tbl_sirup";

public function getOCIDAttribute(){
    return env('OCID') . $this->attributes['sirupID'];
}

public function getYearAttribute(){
    return $this->attributes['tahun'];
}

public function getURIAttribute(){
    return   env('API_ENDPOINT') . "/contract/" . env('OCID') . $this->attributes['sirupID'];
}

public function getTitleAttribute(){
    return $this->attributes['nama'];
}


public function getValueAttribute() {
 
	$value = array(
			'amount' => $this->attributes['pagu'], 
			'currency' => env('CURRENCY')
			);

	 return ($value);
}



}

