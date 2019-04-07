<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class dapil extends Model
{
    protected $table = "dapil";
    protected $primaryKey = "id_dapil";

    public function kecamatan() {
    	return $this
	    	->hasMany("App\model\kecamatan","id_dapil","id_dapil")
	    	->where("isDeleted",false);
    }

    public function calon_dpr() {
    	return $this
	    	->hasMany("App\model\calon_dpr","id_dapil","id_dapil")
	    	->where("isDeleted",false);
    }

    public function partai($id_dapil) {
        return \App\model\partai::where("isDeleted",false)
                ->whereHas("calon_dpr", function($query) use ($id_dapil) {
                    $query->where("id_dapil",$id_dapil);
                })
                ->get();
    }

    public function partaiAll($id_dapil) {
        return partai::where("isDeleted",false)->get();
    }
}
