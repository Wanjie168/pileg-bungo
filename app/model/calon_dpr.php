<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class calon_dpr extends Model
{
    protected $table = "calon_dpr";
    protected $primaryKey = "id_calon";

    public function dapil() {
    	return $this->belongsTo("App\model\dapil","id_dapil","id_dapil");
    }
    public function partai() {
    	return $this->belongsTo("App\model\partai","id_partai","id_partai");
    }
    public function pemilihan() {
    	return $this
            ->hasMany("App\model\pemilihan","id_calon","id_calon")
            ->where("isDeleted",false);
    }
    public function hitungSuaraByTPS($id_calon,$id_tps) {
        return \App\model\pemilihan::where("id_calon",$id_calon)
                ->where("id_tps",$id_tps)
                ->first()
                ->jumlah_suara;
    }
    public function hitungSuaraByDapil($id_calon,$id_dapil) {
        return \App\model\pemilihan::where("id_calon",$id_calon)
                ->whereHas("tps.desa.kecamatan.dapil",function($query) use ($id_dapil) {
                    $query->where("id_dapil",$id_dapil);
                })
                ->sum("jumlah_suara");
    }
    public function hitungSuaraKeseluruhan($id_calon) {
        return \App\model\pemilihan::where("id_calon",$id_calon)
                ->sum("jumlah_suara");
    }
}
