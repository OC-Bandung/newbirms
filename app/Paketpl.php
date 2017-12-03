<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paketpl extends Model
{
    protected $table = env('DB_CONTRACT')."."."vpl_bypaket";
}
