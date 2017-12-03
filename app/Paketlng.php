<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paketlng extends Model
{
	protected $appends = array('tahun' , 'nilaikontrak' );

	protected $visible = array('tahun' , 'nilaikontrak' );

    protected $table = "2017_birms_econtract.vlelang_bypaket";
}
