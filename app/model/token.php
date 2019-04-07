<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class token extends Model
{
    protected $table = "token";
    protected $primaryKey = "id_token";

    public function tps() {
    	return $this->belongsTo('App\model\tps','id_tps','id_tps');
    }

    public function reset() {
    	// truncate tabel token
    	return token::where("token","!=",true)->delete();
    }
}
