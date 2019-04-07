<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class pemilihan extends Model
{
    protected $table = "pemilihan";
    protected $primaryKey = "id_pemilihan";

    public function tps() {
    	return $this->belongsTo('App\model\tps','id_tps','id_tps');
    }
}
