<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class GlobalController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function doDecrypt($token) {
        try {
            $token = Crypt::decrypt($token);
            return $token;
        } catch (DecryptException $e) {
            return false;
        };
    }
}
