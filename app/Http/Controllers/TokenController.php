<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\tps;
use Route;

class TokenController extends Controller
{
    public function index() {
    	//dd(Route::currentRouteName());
    	$tps = tps::where("isDeleted",false)
    			->with("desa.kecamatan.dapil")
    			->with("token")
    			->get();
    	return view("token.index")
    		->with("tps",$tps);
    }
}
