<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class kecamatan extends Model
{
    protected $table = "kecamatan";
    protected $primaryKey = "id_kecamatan";

    public function dapil() {
    	return $this->belongsTo("App\model\dapil","id_dapil","id_dapil");
    }

    public function desa() {
    	return $this
    		->hasMany("App\model\desa","id_kecamatan","id_kecamatan")
    		->where("isDeleted",false);
    }
}
