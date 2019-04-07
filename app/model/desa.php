<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class desa extends Model
{
    protected $table = "desa";
    protected $primaryKey = "id_desa";

    public function kecamatan() {
    	return $this->belongsTo("App\model\kecamatan","id_kecamatan","id_kecamatan");
    }

    public function tps() {
    	return $this
    		->hasMany('App\model\tps','id_desa','id_desa')
    		->where("isDeleted",false);
    }
}
