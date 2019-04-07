<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\dapil;
use App\model\kecamatan;
use App\model\desa;
use App\model\tps;
use App\model\submitted_tps;
use App\model\pemilihan;
use App\model\token;
use App\model\coblos_partai;
use Crypt;

class AjaxController extends Controller
{
    function getKecamatan($id=null) {
    	if($id==null) return [];
    	return dapil::where("id_dapil",$id)->with("kecamatan")->first();
    }

    function getDesa($id=null) {
    	if($id==null) return [];
    	return kecamatan::where("id_kecamatan",$id)->with("desa")->first();
    }

    function getTPS($id=null) {
    	if($id==null) return [];
    	return desa::where("id_desa",$id)->with("tps")->first();
    }

    function getDataSuara($id=null) {
    	if($id==null) return [];
    	return tps::where("id_tps",$id)
    			->with("desa.kecamatan.dapil.calon_dpr.partai")
    			->first();
    }

    function submitSuara(Request $data) {
        if(
            $data->has("id_tps") &&
            $data->has("suara") &&
            $data->has("suara_partai")
        ) {
            $data->id_tps = Crypt::decrypt($data->id_tps); // decrypt id
            // has submit before
            $hasSubmit = submitted_tps::where("id_tps",$data->id_tps)->first();
            if($hasSubmit)
                return [
                    "success" => false,
                    "pesan"   => "TPS ini telah mensubmit suara!",
                ];
            $tambah = new submitted_tps;
                $tambah->id_tps = $data->id_tps;
            if($tambah->save()) {
                // Input data suara ke table 'pemilihan'
                foreach ($data->suara as $key => $value) {
                    $tambah_suara = new pemilihan;
                        $tambah_suara->id_tps       = $data->id_tps;
                        $tambah_suara->id_calon     = $value['id_calon'];
                        $tambah_suara->jumlah_suara = $value['suara'];
                    $tambah_suara->save();
                };
                foreach ($data->suara_partai as $key => $value) {
                    $tambah_suara = new coblos_partai;
                        $tambah_suara->id_tps       = $data->id_tps;
                        $tambah_suara->id_partai    = $value['id_partai'];
                        $tambah_suara->jumlah_suara = $value['suara'];
                    $tambah_suara->save();
                };
                return [
                    "success" => true,
                    "pesan"   => "Data suara TPS berhasil disubmit!",
                ];
            } else
                return [
                    "success" => false,
                    "pesan"   => "Data suara TPS gagal disubmit!",
                ];
        } else
            return [
                "success" => false,
                "pesan"   => "Akses tidak valid!",
            ];
    }

    function submitToken(Request $data) {
        if($data->has("token")) {
            $token = token::where("token",$data->token)->first();
            if($token) {
                $update = token::where("token",$data->token)->update([
                    "hasUsed" => true
                ]);
                return [
                    "success" => true,
                    "token"   => Crypt::encrypt($token->id_tps),
                ];
            } else
            return [
                "success" => false,
                "pesan"   => "Kode token tidak valid!",
            ];
        } else
            return [
                "success" => false,
                "pesan"   => "Akses tidak valid!",
            ];
    }

    function generateToken() {
        $token = new token;
        $reset = $token->reset(); // reset token (hapus data token);
        $tps   = tps::where("isDeleted",false)->get();
        foreach ($tps as $key => $value) {
            $useToken = false;
            while (!$useToken) {
                $token = str_random(5);
                $cekToken = token::where("token",$token)->first();
                if($cekToken)
                    $useToken = false; // token sudah ada
                else
                    $useToken = true; // token belum ada
                if($useToken) {
                    $saveToken = new token;
                        $saveToken->token  = $token;
                        $saveToken->id_tps = $value->id_tps;
                    $saveToken->save();
                };
            };
        };
        return [
            "success" => true,
            "pesan"   => "Token berhasil dibangkitkan!",
        ];
    }

    function submitSuaraPartai(Request $data) {
        if(
            $data->has("id_tps") &&
            $data->has("suara")
        ) {
            $data->id_tps = Crypt::decrypt($data->id_tps); // decrypt id
            // has submit before
            $hasSubmit = submitted_tps::where("id_tps",$data->id_tps)->first();
            if($hasSubmit)
                return [
                    "success" => false,
                    "pesan"   => "TPS ini telah mensubmit suara!",
                ];
            $tambah = new submitted_tps;
                $tambah->id_tps = $data->id_tps;
            if($tambah->save()) {
                // Input data suara ke table 'pemilihan'
                foreach ($data->suara as $key => $value) {
                    $tambah_suara = new pemilihan;
                        $tambah_suara->id_tps       = $data->id_tps;
                        $tambah_suara->id_calon     = $value['id_calon'];
                        $tambah_suara->jumlah_suara = $value['suara'];
                    $tambah_suara->save();
                };
                return [
                    "success" => true,
                    "pesan"   => "Data suara TPS berhasil disubmit!",
                ];
            } else
                return [
                    "success" => false,
                    "pesan"   => "Data suara TPS gagal disubmit!",
                ];
        } else
            return [
                "success" => false,
                "pesan"   => "Akses tidak valid!",
            ];
    }
}
