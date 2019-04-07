<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class coblos_partai extends Model
{
    protected $table = "coblos_partai";

    public function partai() {
    	return $this->belongsTo("App\model\partai","id_partai","id_partai");
    }

    public function tps() {
    	return $this->belongsTo('App\model\tps',"id_tps","id_tps");
    }
}
