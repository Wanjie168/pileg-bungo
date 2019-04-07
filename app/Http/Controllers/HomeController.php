<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\dapil;
use App\model\kecamatan;
use App\model\desa;
use App\model\tps;
use App\model\partai;
use App\model\calon_dpr;
use App\model\submitted_tps;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dapil      = dapil::where("isDeleted",false)->count();
        $kecamatan  = kecamatan::where("isDeleted",false)->count();
        $desa       = desa::where("isDeleted",false)->count();
        $tps        = tps::where("isDeleted",false)->count();
        $partai     = partai::where("isDeleted",false)->count();
        $calon_dpr  = calon_dpr::where("isDeleted",false)->count();
        $submitted  = submitted_tps::count();
        $spartai    = partai::with("calon_dpr")->where("isDeleted",false)->get();
        return view('home')
            ->with('dapil',$dapil)
            ->with('kecamatan',$kecamatan)
            ->with('desa',$desa)
            ->with('tps',$tps)
            ->with('partai',$partai)
            ->with('calon_dpr',$calon_dpr)
            ->with('submitted_tps',$submitted)
            ->with('spartai',$spartai);
    }
}
