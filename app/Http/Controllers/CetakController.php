<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Crypt; // debug only
use App\model\tps;
use App\model\partai;
use App\model\dapil;
use PDF;

class CetakController extends Controller
{
    public function doDecrypt($token) {
        try {
            $token = Crypt::decrypt($token);
            return $token;
        } catch (DecryptException $e) {
            return false;
        };
    }

    public function index($file=null) {
    	//$file = Crypt::encrypt("laporan"); // debug only

    	if($file==null || !$this->doDecrypt($file))
    		return [
    			"success" => false,
    			"pesan"   => "Tidak ada berkas yang akan dicetak!",
    		];

    	$file = $this->doDecrypt($file);

    	if($file=="token")
    		return $this->cetakToken(); else
    	if($file=="laporan")
    		return $this->cetakLaporan(); else
    		return [
    			"success" => false,
    			"pesan"   => "Akses tidak dikenal!",
    		];
    }

    protected function cetakToken() {
    	$tps = tps::where("isDeleted",false)
    			->with("desa.kecamatan.dapil")
    			->with("token")
    			->get();
    	return view("pdf.token")->with("tps",$tps); // debug
    	$pdf = PDF::loadView('pdf.token', ['tps' => $tps])
    			->setPaper("a4","landscape");
    	return $pdf->stream("Kode Akses (Token) TPS.pdf",array("Attachment" => false))
	    	->header('Content-Type','application/pdf');
    }

    protected function cetakLaporan() {
    	$dapil  = dapil::where("isDeleted",false)
    				->orderBy("nama_dapil","ASC")
    				->get();
    	return view("pdf.laporan")->with("dapil",$dapil); // debug
    	$pdf = PDF::loadView('pdf.laporan', ['dapil' => $dapil])
    			->setPaper("a4","potrait");
    	return $pdf->stream("Rekap Pemungutan Suara.pdf",array("Attachment" => false))
	    	->header('Content-Type','application/pdf');
    }
}
