<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\model\pemilihan;

class LandingController extends Controller
{
    public function index() {
        $suara_masuk = pemilihan::sum('jumlah_suara');
        return view("welcome")->with("suara_masuk",$suara_masuk);
    }
}
