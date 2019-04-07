<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\dapil;
use App\model\kecamatan;
use App\model\desa;
use App\model\tps;
use App\model\submitted_tps;
use App\model\partai;
use App\model\calon_dpr;
use Session;

class PemungutanSuaraController extends GlobalController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pemungutan_suara.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        if(!$this->doDecrypt($id)) {
            Session::flash("error","Kode token tidak valid!");
            return redirect(Route('pemungutan_suara.index'));
        }
        $id = $this->doDecrypt($id);
        // cek sudah pernah submit atau belum
        if($this->hasSubmit($id)) {
            Session::flash("error","TPS ini telah mensubmit data suara!");
            return redirect(Route('pemungutan_suara.index'));
        }
        else {
            $infoTPS   = tps::where("id_tps",$id)->with("desa.kecamatan.dapil")->first();
            $dapil     = $infoTPS->desa->kecamatan->dapil;
            $partai    = partai::where("isDeleted",false)
                            ->with("calon_dpr")
                            ->whereHas("calon_dpr", function($query) use ($dapil) {
                                $query->where("id_dapil",$dapil->id_dapil);
                            })
                            ->get();
            $partaiKosong   = partai::where("isDeleted",false)
                            ->whereNotIn("id_partai",
                                partai::select("id_partai")
                                ->where("isDeleted",false)
                                ->whereHas("calon_dpr", function($query) use ($dapil) {
                                        $query->where("id_dapil",$dapil->id_dapil);
                                })
                                ->get()
                            )
                            ->get();
            return view("pemungutan_suara.input")
                    ->with("infoTPS",$infoTPS)
                    ->with("partai",$partai)
                    ->with("partaiKosong",$partaiKosong);
        }
    }

    protected function hasSubmit($id) {
        $data = submitted_tps::where("id_tps",$id)->first();
        if($data) return true; else return false;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function read() {
        $dapil = dapil::where("isDeleted",false)->orderBy("nama_dapil","ASC")->get();
        $tps = tps::where("isDeleted",false)
                ->whereIn("id_tps",
                    submitted_tps::select("id_tps")->groupBy("id_tps")->get()
                )
                ->with("desa.kecamatan.dapil")
                ->get();
        return view("pemungutan_suara.read")
            ->with("dapil",$dapil)
            ->with("tps",$tps);
    }

    public function detail($id="null") {
        if(!$this->doDecrypt($id))
            return [
                "success" => false,
                "pesan"   => "Kode akses tidak valid!",
            ];
        $id = $this->doDecrypt($id);
        $infoTPS   = tps::where("id_tps",$id)
                        ->with("desa.kecamatan.dapil")
                        ->first();
        $dapil     = $infoTPS->desa->kecamatan->dapil;
        $partai    = partai::with("calon_dpr")
                        ->whereHas("calon_dpr", function($query) use ($dapil) {
                            $query->where("id_dapil",$dapil->id_dapil);
                        })
                        ->where("isDeleted",false)
                        ->get();
        return view("suara_terkumpul.tps")
            ->with("infoTPS",$infoTPS)
            ->with("partai",$partai);
    }

    public function detailDapil($id="null") {
        if(!$this->doDecrypt($id))
            return [
                "success" => false,
                "pesan"   => "Kode akses tidak valid!",
            ];
        $id = $this->doDecrypt($id);
        $infoDapil = dapil::where("id_dapil",$id)->first();
        $partai    = partai::with("calon_dpr")
                        ->whereHas("calon_dpr", function($query) use ($infoDapil) {
                            $query->where("id_dapil",$infoDapil->id_dapil);
                        })
                        ->where("isDeleted",false)
                        ->get();
        return view("suara_terkumpul.dapil")
            ->with("infoDapil",$infoDapil)
            ->with("partai",$partai);
    }
}
