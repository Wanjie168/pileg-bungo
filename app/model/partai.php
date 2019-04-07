<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class partai extends Model
{
    protected $table = "partai";
    protected $primaryKey = "id_partai";

    public function calon_dpr() {
    	return $this
    		->hasMany("App\model\calon_dpr","id_partai","id_partai")
    		->where("isDeleted",false);
    }

    public function calon_dpr2($id_partai,$id_dapil) {
        return \App\model\calon_dpr::where("id_partai",$id_partai)
            ->where("id_dapil",$id_dapil)
            ->where("isDeleted",false)
            ->get();
    }

    public function hitung_suara_partai($id_partai) {
    	$calon_dpr = partai::where("id_partai",$id_partai)->with("calon_dpr")->first();
    	if($calon_dpr->calon_dpr==null) return 0;
    	$suara = 0;
    	foreach ($calon_dpr->calon_dpr as $key => $value) {
    		$suara+=$value->hitungSuaraKeseluruhan($value->id_calon);
    	};
    	return $suara;
    }

    public function hitung_suara_coblos_partai($id_partai,$id_dapil) {
        return \App\model\coblos_partai::where("id_partai",$id_partai)
                ->whereIn("id_tps",
                    \App\model\tps::select("id_tps")
                    ->whereHas("desa.kecamatan.dapil",function($query) use ($id_dapil) {
                        $query->where("id_dapil",$id_dapil);
                    })->get()
                )
                ->sum("jumlah_suara");
    }
}
