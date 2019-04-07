<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class submitted_tps extends Model
{
    protected $table = "submitted_tps";
    protected $primaryKey = "id_tps";

    public function tps() {
    	return $this->belongsTo('App\model\tps','id_tps','id_tps');
    }

    public function reset() {
    	//return Model::delete();
    }
}
