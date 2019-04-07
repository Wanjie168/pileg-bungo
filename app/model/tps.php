<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class tps extends Model
{
    protected $table = "tps";
    protected $primaryKey = "id_tps";

    public function desa() {
    	return $this->belongsTo("App\model\desa","id_desa","id_desa");
    }

    public function token() {
    	return $this->hasOne('App\model\token','id_tps','id_tps');
    }

    public function pemilihan() {
    	return $this
            ->hasMany('App\model\pemilihan','id_tps','id_tps')
            ->where("isDeleted",false);
    }
}
